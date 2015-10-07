<?php

namespace app\models;


use app\components\ArChangeLoggerBehavior;

class LunchRight extends LunchRightBase{

    const STATUS_FULL="FULL";

    public function behaviors()
    {

        return [
            [
                'class'   => ArChangeLoggerBehavior::className(),
                'logClassName' => 'étkezési jog',
                'logNameProperty' => function () {
                    return $this->lunch_date;
                },
            ]
        ];
    }
}