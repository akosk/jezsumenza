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
                [['language', 'yami_id', 'barcode'], 'string'],
                [['school_class_id'], 'integer'],
                [['barcode', 'yami_id'], 'unique'],
                [['eating_time_start', 'eating_time_end', 'eating_time_start_weekday_1', 'eating_time_end_weekday_1', 'eating_time_start_weekday_2', 'eating_time_end_weekday_2', 'eating_time_start_weekday_3', 'eating_time_end_weekday_3', 'eating_time_start_weekday_4', 'eating_time_end_weekday_4', 'eating_time_start_weekday_5', 'eating_time_end_weekday_5'], 'safe'],
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
                'barcode'           => 'Kártyaazonosító',
                'language'          => 'Nyelv',
            ]

        );
        return $merged;
    }

    public function getSchoolClass()
    {
        return $this->hasOne(SchoolClass::className(), ['id' => 'school_class_id']);
    }

    public function beforeValidate()
    {
        $this->gravatar_email = $this->public_email;
        return parent::beforeValidate();
    }

    public function htmlName()
    {
        return $this->user->inactive?
            "<span class='text-warning'> {$this->name}</span>":
            $this->name;
    }

}