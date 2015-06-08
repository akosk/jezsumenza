<?php
/**
 * Created: Ákos Kiszely
 * Date: 2014.11.17.
 * Time: 12:00
 */

namespace app\controllers;

use Yii;
use yii\base\InlineAction;
use app\models\User;
use dektrium\user\controllers\SecurityController as BaseSecurityController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class SecurityController extends BaseSecurityController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['login', 'auth'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['logout'], 'roles' => ['@']],
                ]
            ],

        ];
    }
}