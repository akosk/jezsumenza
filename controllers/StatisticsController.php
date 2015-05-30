<?php

namespace app\controllers;

use app\models\FoodSearch;
use app\models\ProblematicStudent;
use Yii;

class StatisticsController extends \yii\web\Controller
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


}
