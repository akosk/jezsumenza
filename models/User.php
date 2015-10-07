<?php

namespace app\models;

use app\components\ArChangeLoggerBehavior;
use dektrium\user\helpers\Password;
use dektrium\user\models\User as BaseUser;
use Yii;
use yii\helpers\ArrayHelper;
use yii\log\Logger;

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

    /** @inheritdoc */
    public function rules()
    {
        return [
            // username rules
            ['username', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            ['username', 'unique'],
            ['username', 'trim'],

            // email rules
            ['email', 'string', 'max' => 255],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            ['email', 'trim'],

            // password rules
            ['password', 'required', 'on' => ['register']],
            ['password', 'string', 'min' => 3, 'on' => ['register', 'create']],
        ];
    }

    public function create()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->confirmed_at = time();

        if ($this->password == null) {
            $this->password = Password::generate(8);
        }

        $this->trigger(self::USER_CREATE_INIT);

        if ($this->save()) {
            $this->trigger(self::USER_CREATE_DONE);
//            $this->mailer->sendWelcomeMessage($this);
//            \Yii::getLogger()->log('User has been created', Logger::LEVEL_INFO);
            return true;
        }

        \Yii::getLogger()->log('An error occurred while creating user account', Logger::LEVEL_ERROR);

        return false;
    }

    public static function hasRole($user_id, $role)
    {
        $hasRole = \Yii::$app->authManager->checkAccess($user_id, $role);
        return $hasRole;
    }

    public function getEatingTimeStart()
    {
        if (self::hasRole($this->id, 'teacher')) {
            return null;
        }

        if ($this->profile->eating_time_start != null) {
            return $this->profile->eating_time_start;
        }

        $weekday = date('w');
        $field = "eating_time_start_weekday_{$weekday}";
        if ($this->profile->schoolClass->$field != null) {
            return $this->profile->schoolClass->$field;
        }

        if ($this->profile->schoolClass->eating_time_start != null) {
            return $this->profile->schoolClass->eating_time_start;
        }

        return null;
    }

    public function getEatingTimeEnd()
    {
        if (self::hasRole($this->id, 'teacher')) {
            return null;
        }

        if ($this->profile->eating_time_end != null) {
            return $this->profile->eating_time_end;
        }

        $weekday = date('w');
        $field = "eating_time_end_weekday_{$weekday}";
        if ($this->profile->schoolClass->$field != null) {
            return $this->profile->schoolClass->$field;
        }

        if ($this->profile->schoolClass->eating_time_end != null) {
            return $this->profile->schoolClass->eating_time_end;
        }

        return null;
    }

    public function isWithinEatingTime($timeFrom, $timeTo, $time)
    {
        if (self::hasRole($this->id, 'teacher')) {
            return true;
        }

        return ($time >= $timeFrom || $timeFrom===null)  && ($time < $timeTo || $timeTo===null);
    }

    public function getLunchRight($date)
    {
        return $this->hasOne(LunchRight::className(), ['user_id' => 'id'])->onCondition(['lunch_date' => $date]);
    }

    public function getRole()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }
}