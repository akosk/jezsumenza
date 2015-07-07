<?php

namespace app\controllers;

use app\models\ArChangeLog;
use Exception;
use Yii;
use yii\db\Connection;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Response;

class SiteController extends ControllerBase
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'actions' => ['logout', 'index','dina', 'dinapic'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->can('student') || Yii::$app->user->can('teacher')) {
            $this->redirect(Url::toRoute('/lunch-choice/index'));
        }
        return $this->render('index');
    }

    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionDina($tanaz, $tanuloazonosito)
    {

        $db = Yii::$app->dbDina;
        /**@var Connection $db */

        $q = "SELECT COUNT(*) FROM dbo.tanulo WHERE dbo.tanulo.TanAz=:tanaz AND dbo.tanulo.tanuloazonosito=:tanuloazonosito";

        $data = $db->createCommand($q, [
            ':tanaz'           => $tanaz,
            ':tanuloazonosito' => $tanuloazonosito
        ])->queryScalar();
        print_r($data);
    }

    //        $response = Yii::$app->getResponse();
//        $response->headers->set('Content-Type', 'image/jpeg');
//        $response->format = Response::FORMAT_RAW;

    public function actionDinapic($tanaz)
    {
        $db = Yii::$app->dbDinaPic;
        /**@var Connection $db */

        $q = "SELECT * FROM dbo.Pic WHERE dbo.Pic.tanaz=:tanaz";

        try {
            $data = $db->createCommand($q, [
                ':tanaz' => $tanaz,
            ])->queryOne();
        } catch (Exception $e) {

        }


        if ($data['kep'] != '') {
            header("Content-type: image/bmp");
            echo hex2bin($data['kep']);
        } else {
            $d=__DIR__;
            $data=readfile($d.'/../web/images/anonymous.jpg');
            header("Content-type: image/jpg");
            echo $data;
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}
