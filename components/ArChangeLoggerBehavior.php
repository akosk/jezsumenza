<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.04.22.
 * Time: 6:34
 */

namespace app\components;

use app\models\ArChangeLog;
use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\db\Expression;

class ArChangeLoggerBehavior extends Behavior
{

    const LOG_CATEGORY = "public";

    public $logClassName = 'object';
    public $logNameProperty = 'name';
    public $primaryKey="id";

    const DELETED = '#DELETED#';
    private $attributes = [];
    public $relations = [];
    private $relationData = [];

    public $markDbExpressionsAsDiff = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND    => 'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeInsert',
            ActiveRecord::EVENT_AFTER_INSERT  => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE  => 'afterDelete',
        ];
    }

    public function afterFind($event)
    {
        $owner = $this->owner;
        $this->relationData = $this->getAllRelationData($owner);
    }

    public function beforeInsert($event)
    {
        $this->attributes = $this->owner->oldAttributes;
    }

    public function afterDelete($event)
    {
        $this->log('törölve');
        $this->deleteItem();
    }

    public function afterInsert($event)
    {
        $this->log('létrehozva');
        $this->saveItem();
    }

    public function afterUpdate($event)
    {
        $this->log('módosítva');
        $this->saveItem();
    }

    public function getAllRelationData($owner)
    {
        $result = [];
        foreach ($this->relations as $relation) {
            $result[$relation] = $this->getRelationIds($relation, $owner);
        }
        return $result;
    }

    public function getRelationIds($relation, $owner)
    {
        $items = $owner->{$relation};
        $val = [];
        foreach ($items as $item) {
            $val[] = $item->id;
        }
        return implode(',', $val);
    }

    public function attributesDiff($owner)
    {
        $array_diff = array_diff_assoc($owner->attributes, $this->attributes);

        if ($this->markDbExpressionsAsDiff) {
            $array_diff = array_filter($array_diff, function ($item) {
                return !($item instanceof CDbExpression);
            });
        }
        return $array_diff;
    }

    private function relationsDiff($owner)
    {
        $newRelationData = $this->getAllRelationData($owner);
        $array_diff = array_diff_assoc($this->relationData, $newRelationData);
        return $array_diff;
    }

    private function log($string)
    {
        $prop = $this->logNameProperty;
        $name = "";
        if (is_callable($prop)) {
            $name = $prop();
        } else {
            $name = $this->owner->$prop;
        }

        Yii::info("{$this->logClassName} {$string}. ({$name})", self::LOG_CATEGORY);
    }

    public function deleteItem()
    {
        $owner = $this->owner;
        $change = new ArChangeLog();
        $change->action_hash = Yii::$app->getSecurity()->generateRandomString();
        $change->editor_id = \Yii::$app->user->id;
        $change->classname = get_class($owner);
        $primaryKey=$this->primaryKey;
        $change->item_id = $owner->$primaryKey;
        $change->property = self::DELETED;
        $change->create_time = new Expression('NOW()');
        $change->save();
    }

    public function saveItem()
    {
        $owner = $this->owner;
        $attributes_diff = $this->attributesDiff($owner);

        $owner->refresh();
        $relations_diff = $this->relationsDiff($owner);

        $this->attributes = array_merge($this->attributes, $relations_diff);
        $attributes_diff = array_merge($attributes_diff, $relations_diff);

        $action_hash = Yii::$app->getSecurity()->generateRandomString();

        $primaryKey=$this->primaryKey;

        foreach ($attributes_diff as $key => $item) {
            $change = new ArChangeLog();
            $change->action_hash = $action_hash;
            $change->editor_id = \Yii::$app->user->id;
            $change->classname = get_class($owner);
            $change->item_id = $owner->$primaryKey;
            $change->property = $key;
            $change->old_value = $this->attributes[$key];
            $change->new_value = (string)(isset($this->relations[$key]) ? $this->getRelationIds($key,
                $owner) : $owner->{$key});
            $change->create_time = new Expression('NOW()');
            $change->save();
        }
    }
}