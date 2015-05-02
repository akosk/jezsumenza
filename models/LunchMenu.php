<?php

namespace app\models;

use app\components\ArChangeLoggerBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class LunchMenu extends LunchMenuBase
{

    public $formFoods = [];

    public function behaviors()
    {

        return [
            [
                'class'   => ArChangeLoggerBehavior::className(),
                'logClassName' => 'menü',
                'logNameProperty' => function () {
                    return $this->date.' "'.$this->letter.'"';
                },
            ]
        ];
    }

    public function rules()
    {
        $rules = ArrayHelper::merge(
            parent::rules(), [['formFoods', 'safe']]
        );
        return $rules;
    }

    public function beforeValidate()
    {
        if ($this->create_time === null) {
            $this->create_time = new Expression('NOW()');
        }
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        $this->formFoods = [];
        foreach ($this->lunchMenuFoods as $item) {
            $this->formFoods[]=$item->food_id;
        }

        parent::afterFind();
    }

    public function afterSave($insert, $changedAttributes)
    {
        LunchMenuFood::deleteAll('lunch_menu_id=:id', [':id' => $this->id]);
        foreach ($this->formFoods as $id) {
            $lunchMenuFood = new LunchMenuFood();
            $lunchMenuFood->lunch_menu_id = $this->id;
            $lunchMenuFood->food_id = $id;
            $lunchMenuFood->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }
}