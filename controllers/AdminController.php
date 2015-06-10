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
use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class AdminController extends BaseAdminController
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
//            'verbs'  => [
//                'class'   => VerbFilter::className(),
//                'actions' => [
//                    'delete'  => ['post'],
//                    'confirm' => ['post'],
//                    'block'   => ['post']
//                ],
//            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'block', 'confirm'],
                        'allow'   => true,
                        'roles'   => ['admin', 'economic'],
                    ],
                ]
            ]
        ];
    }

    public function actionCreate()
    {
        /** @var User $user */
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->create()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been created'));
            return $this->redirect(['update','id'=>$user->id]);
        }

        return $this->render('create', [
            'user' => $user
        ]);
    }


}