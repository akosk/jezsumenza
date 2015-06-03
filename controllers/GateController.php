<?php

namespace app\controllers;

use app\assets\GateAsset;
use app\models\GateEvent;
use app\models\LunchChoice;
use app\models\LunchMenu;
use app\models\Profile;
use Yii;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\HttpException;

class GateController extends \yii\web\Controller
{
    public function actionGateOne()
    {
        GateAsset::register($this->getView());

        return $this->render('gate-one');
    }

    public function actionGateTwo()
    {
        GateAsset::register($this->getView());

        return $this->render('gate-two');
    }

    public function actionGateEvent($gate, $barcode)
    {
        $profile = Profile::find()->where('barcode=:barcode', [':barcode' => $barcode])->one();

        $gateEvent = new GateEvent();
        $gateEvent->user_id = $profile->user_id;
        $gateEvent->create_time = new Expression('NOW()');
        $gateEvent->gate = $gate;
        if (!$gateEvent->save()) {
            throw new HttpException(500, 'Hiba a kapu esemény mentése során.');
        }

        $user = $profile->user;

        $eatingTimeStart = $user->getEatingTimeStart();
        $eatingTimeEnd = $user->getEatingTimeEnd();

        $currentDateTime = new \DateTime();
        $currentTime = $currentDateTime->format('H:i:s');
        $currentDate = $currentDateTime->format('Y-m-d');
        $lunchChoice = LunchChoice::find()
            ->joinWith('lunchMenu')
            ->where('lunch_menu.date=:date AND user_id=:userId', [
                ':date'   => $currentDate,
                ':userId' => $user->id
            ])
            ->one();

        if (!$lunchChoice) {
            throw new HttpException(500,'Nem választott menüt.');
        }

        $respone = [
            'gate'               => $gate,
            'timestamp'          => $currentDateTime->getTimestamp(),
            'date'               => $currentDate,
            'time'               => $currentTime,
            'user_name'          => $profile->name,
            'barcode'            => $barcode,
            'school_class'       => $profile->schoolClass->name,
            'eating_time_start'  => $eatingTimeStart,
            'eating_time_end'    => $eatingTimeEnd,
            'paid'               => $user->getLunchRight($currentDate)->one() != null,
            'within_eating_time' => $user->isWithinEatingTime($eatingTimeStart, $eatingTimeEnd, $currentTime),
            'lunch_menu'         => $lunchChoice->lunchMenu->letter,
            'lunch_menu_food'    => array_map(function ($item) {
                return [
                    'category' => $item->category,
                    'name' => $item->translate(Yii::$app->language)->name,
                ];
            }, $lunchChoice->lunchMenu->foods),

        ];

        return Json::encode($respone);
    }
}