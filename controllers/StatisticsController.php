<?php

namespace app\controllers;

use app\models\FoodSearch;
use app\models\MissedLunch;
use app\models\NoOrder;
use app\models\ProblematicStudent;
use Yii;

class StatisticsController extends ControllerBase
{
    public function actionFoods()
    {
        $foodSearch = new FoodSearch;
        $dataProvider = $foodSearch->searchFoodStat(Yii::$app->request->queryParams);

        return $this->render('foods', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $foodSearch
        ]);
    }

    public function actionProblematicStudents()
    {
        $problematicStudent = new ProblematicStudent();
        $dataProvider = $problematicStudent->search(Yii::$app->request->queryParams);


        return $this->render('problematic-students', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $problematicStudent
        ]);
    }

    public function actionMissedLunch()
    {
        $missedLunch = new MissedLunch();
        $dataProvider = $missedLunch->search(Yii::$app->request->queryParams);


        return $this->render('missed-lunch', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $missedLunch
        ]);
    }

    public function actionNoOrder()
    {
        $noOrder = new NoOrder();
        $dataProvider = $noOrder->search(Yii::$app->request->queryParams);


        return $this->render('no-order', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $noOrder
        ]);
    }


}
