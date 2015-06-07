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

    /**
     * @param $lastMonday
     * @param $nextSunday
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getLunchMenusByDay($lastMonday, $nextSunday)
    {
        $lunchMenus = LunchMenu::find()->where('date BETWEEN :date1 AND :date2',
            [
                ':date1' => $lastMonday,
                ':date2' => $nextSunday,
            ])->orderBy('date')->all();

        $data = array_reduce($lunchMenus, function ($carry, $item) {
            if (!isset($carry[$item->date])) {
                $carry[$item->date] = [];
            }
            $carry[$item->date][] = $item;
            return $carry;
        }, []);
        return $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(LunchChoice::className(), ['lunch_menu_id' => 'id']);
    }

    public function getUsersCount()
    {
        return $this->hasMany(LunchChoice::className(), ['lunch_menu_id' => 'id'])->count();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'letter' => 'Betű-kód',
            'date' => 'Dátum',
            'create_time' => 'Létrehozás dátuma',
        ];
    }

    public function getFoodsSorted()
    {
        return $this->hasMany(Food::className(), ['id' => 'food_id'])
            ->viaTable('lunch_menu_food', ['lunch_menu_id' => 'id'])
            ->addOrderBy(['category' => SORT_DESC]);
    }

}