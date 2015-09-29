<?php
/**
 * Created: Ákos Kiszely
 * Date: 2014.11.17.
 * Time: 12:00
 */

namespace app\controllers;

use app\models\LoginForm;
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
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    ['allow' => true, 'actions' => ['login', 'auth'], 'roles' => ['?']],
//                    ['allow' => true, 'actions' => ['logout'], 'roles' => ['@']],
//                ]
//            ],

        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $url = Url::home();
            Yii::$app->response->redirect($url);
            Yii::$app->end();
        }

        $model = \Yii::createObject(LoginForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}