<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.06.04.
 * Time: 14:55
 */


namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class ControllerBase extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->can('student') || Yii::$app->user->can('teacher')) {
            $this->layout='student';
        }

        return parent::beforeAction($action);
    }
}

