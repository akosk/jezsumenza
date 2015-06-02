<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SchoolClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Osztályok';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-class-index">

    <h1><?= Html::a('Osztály létrehozása', ['create'], ['class' => 'btn btn-success']) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'eating_time_start',
            'eating_time_end',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
