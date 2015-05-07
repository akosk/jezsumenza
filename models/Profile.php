<?php

namespace app\models;

use app\components\ArChangeLoggerBehavior;
use dektrium\user\models\Profile as BaseProfile;
use Yii;
use yii\helpers\ArrayHelper;

class Profile extends BaseProfile
{

    public function behaviors()
    {

        return ArrayHelper::merge(
            parent::behaviors(), [
                [
                    'class'           => ArChangeLoggerBehavior::className(),
                    'primaryKey'      => 'user_id',
                    'logClassName'    => 'felhasználó profil',
                    'logNameProperty' => function () {
                        return $this->user->username;
                    },
                ],

            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['dina_id'], 'string'],
                [['school_class_id'], 'integer'],
                [['eating_time_start', 'eating_time_end'], 'safe'],
            ]

        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
                [
                    'dina_id'         => \Yii::t('user', 'Dina id'),
                    'school_class_id' => \Yii::t('user', 'Osztály'),
                    'eating_time_start' => 'Eating Time Start',
                    'eating_time_end' => 'Eating Time End',
                ],

            ]
        );
    }
}