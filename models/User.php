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
echo implode(',',$this->getFirstErrors());
        Yii::$app->end();
        \Yii::getLogger()->log('An error occurred while creating user account', Logger::LEVEL_ERROR);

        return false;
    }

    public static function hasRole($user_id, $role){
        $hasRole=\Yii::$app->authManager->checkAccess($user_id,$role);
        return $hasRole;
    }

    public function getEatingTimeStart()
    {
        if (self::hasRole($this->id,'teacher')) {
            return null;
        }
        return $this->profile->eating_time_start != null ?
            $this->profile->eating_time_start :
            $this->profile->schoolClass->eating_time_start;
    }

    public function getEatingTimeEnd()
    {
        if (self::hasRole($this->id,'teacher')) {
            return null;
        }
        return $this->profile->eating_time_end != null ?
            $this->profile->eating_time_end :
            $this->profile->schoolClass->eating_time_end;
    }

    public function isWithinEatingTime($timeFrom, $timeTo, $time)
    {
        if (self::hasRole($this->id,'teacher')) {
            return true;
        }

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