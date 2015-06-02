<?php

namespace app\models;

use app\components\ArChangeLoggerBehavior;
use dektrium\user\models\User as BaseUser;
use Yii;
use yii\helpers\ArrayHelper;

class User extends BaseUser
{

    public function behaviors()
    {

        return ArrayHelper::merge(
            parent::behaviors(), [
                [
                    'class'           => ArChangeLoggerBehavior::className(),
                    'logClassName'    => 'felhasználó',
                    'logNameProperty' => 'username',
                ],

            ]
        );
    }

    public function getEatingTimeStart()
    {
        return $this->profile->eating_time_start != null ?
            $this->profile->eating_time_start :
            $this->profile->schoolClass->eating_time_start;
    }

    public function getEatingTimeEnd()
    {
        return $this->profile->eating_time_end != null ?
            $this->profile->eating_time_end :
            $this->profile->schoolClass->eating_time_end;
    }

    public function isWithinEatingTime($timeFrom, $timeTo, $time)
    {
        return $time >= $timeFrom && $time < $timeTo;
    }

    public function getLunchRight($date)
    {
        return $this->hasOne(LunchRight::className(), ['user_id' => 'id'])->onCondition(['lunch_date' => $date]);
    }

    public function getRole() {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }
}