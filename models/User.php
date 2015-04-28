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
                    'class'   => ArChangeLoggerBehavior::className(),
                    'logClassName' => 'felhasználó',
                    'logNameProperty' => 'username',
                ],

            ]
        );
    }
}