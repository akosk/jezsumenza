<?php

namespace app\controllers;

use app\components\assetbundles\AngularAsset;

class GateController extends \yii\web\Controller
{
    public function actionGateOne()
    {
        AngularAsset::register($this->getView());

        return $this->render('gate-one');
    }

    public function actionGateTwo()
    {
        return $this->render('gate-two');
    }

}
