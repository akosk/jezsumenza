<?php

namespace app\controllers;

use app\components\DateHelper;
use app\models\LunchChoice;
use app\models\LunchMenu;
use DateInterval;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class LunchChoiceController extends \yii\web\Controller
{
    public function actionIndex($date = null)
    {
        $lastMonday = DateHelper::getLastMonday($date);
        $nextSunday = DateHelper::getNextSunday($date);
        $date = new \DateTime($lastMonday);
        $previousWeek = $date->sub(new DateInterval("P7D"))->format('Y-m-d');
        $nextWeek = $date->add(new DateInterval("P14D"))->format('Y-m-d');

        $lunchMenus = LunchMenu::getLunchMenusByDay($lastMonday, $nextSunday);

        $userChoices = LunchChoice::find()->innerJoinWith('lunchMenu')->where('lunch_menu.date BETWEEN :date1 AND :date2
        AND user_id=:userId',
            [
                ':date1'  => $lastMonday,
                ':date2'  => $nextSunday,
                ':userId' => \Yii::$app->user->id,
            ])->orderBy('date')->asArray()->all();

        $userChoices = array_map(function ($item) {
            return $item['lunch_menu_id'];
        }, $userChoices);

        return $this->render('index', [
            'date'         => $lastMonday,
            'lunchMenus'   => $lunchMenus,
            'userChoices'  => $userChoices,
            'previousWeek' => $previousWeek,
            'nextWeek'     => $nextWeek
        ]);
    }

    public function actionSelect($lunch_menu_id)
    {
        $lunchMenu = LunchMenu::findOne($lunch_menu_id);
        if (!$lunchMenu) {
            throw new NotFoundHttpException('A megadott menü nem létezik!');
        }

        $choices = LunchChoice::find()->innerJoinWith('lunchMenu')->where('lunch_menu.date=:date AND user_id=:userId', [
            ':date'   => $lunchMenu->date,
            ':userId' => \Yii::$app->user->id,
        ])->all();
        foreach ($choices as $choice) {
            $choice->delete();
        }

        $lunchChoice = new LunchChoice();
        $lunchChoice->lunch_menu_id = $lunch_menu_id;
        $lunchChoice->user_id = \Yii::$app->user->id;
        $lunchChoice->user_selected = 1;
        $lunchChoice->create_time = new Expression('NOW()');

        if (!$lunchChoice->save()) {
            $errors = array_reduce($lunchChoice->firstErrors, function ($carry, $item) {
                $carry .= $item;
                return $carry;
            }, '');
            throw new ServerErrorHttpException('Model validation errors:' . $errors);
        }
    }

}
