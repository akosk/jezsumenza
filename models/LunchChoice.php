<?php

namespace app\models;

use app\components\ArChangeLoggerBehavior;

class LunchChoice extends LunchChoiceBase
{

    public function behaviors()
    {

        return [
            [
                'class'           => ArChangeLoggerBehavior::className(),
                'logClassName'    => 'menü választás',
                'primaryKey'      => 'lunch_menu_id',
                'logNameProperty' => function () {
                    return $this->lunchMenu->date . " " . $this->lunchMenu->letter;
                },
            ]
        ];
    }
}