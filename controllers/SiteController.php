<?php

namespace app\controllers;

use app\models\ArChangeLog;
use DateTime;
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
            'cache' => [
                'class'        => 'yii\filters\HttpCache',
                'only'         => ['dinapic'],
                'lastModified' => function ($action, $params) {
                    $date = new DateTime("2015-01-31");
                    return $date->getTimestamp();
                },
            ],
            'access' => [

                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['dinapic'],
                        'allow'   => true,
//                        'roles'   => ['@'],
                    ],

                    [
                        'actions' => ['logout', 'index', 'dina'],
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

//            $headers = Yii::$app->response->headers;
//            $headers->remove('Pragma');
//            $headers->add('Content-Type: ','image/bmp');
//            $headers->add('Cache-control','public, max-age='.(60*60*24*365));
//            $headers->add('Expires',gmdate(DATE_RFC1123,time()+60*60*24*365));
//            Yii::$app->response->sendContentAsFile(hex2bin($data['kep']),'image.bmp');

            header('Content-Type:image/bmp');
            echo hex2bin($data['kep']);
        } else {
            $d = __DIR__;
            $data = readfile($d . '/../web/images/anonymous.jpg');
            header("Content-type: image/jpg");
            echo $data;
        }
    }


}
