<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ar_change_log".
 *
 * @property integer $id
 * @property string $action_hash
 * @property integer $editor_id
 * @property string $classname
 * @property integer $item_id
 * @property string $property
 * @property string $old_value
 * @property string $new_value
 * @property string $create_time
 */
class ArChangeLogBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ar_change_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_hash', 'classname', 'item_id', 'property', 'create_time'], 'required'],
            [['editor_id', 'item_id'], 'integer'],
            [['old_value', 'new_value'], 'string'],
            [['create_time'], 'safe'],
            [['action_hash', 'classname', 'property'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action_hash' => 'Action Hash',
            'editor_id' => 'Editor ID',
            'classname' => 'Classname',
            'item_id' => 'Item ID',
            'property' => 'Property',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'create_time' => 'Create Time',
        ];
    }
}
