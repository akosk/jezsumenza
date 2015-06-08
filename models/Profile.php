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
                [['yami_id', 'barcode'], 'string'],
                [['school_class_id'], 'integer'],
                [['eating_time_start', 'eating_time_end'], 'safe'],
            ]

        );
    }

    public function attributeLabels()
    {
        $merged = ArrayHelper::merge(
            parent::attributeLabels(),
                [
                    'yami_id'           => \Yii::t('user', 'Yami azonosító'),
                    'school_class_id'   => \Yii::t('user', 'Osztály'),
                    'eating_time_start' => 'Egyéni étkezési idősáv kezdete',
                    'eating_time_end'   => 'Egyéni étkezési idősáv vége',
                    'barcode'           => 'Vonalkód',
                ]


        );
        return $merged;
    }

    public function getSchoolClass()
    {
        return $this->hasOne(SchoolClass::className(), ['id' => 'school_class_id']);
    }
}