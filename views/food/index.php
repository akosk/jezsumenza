<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ételek';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-index">

    <h1><?= Html::a('Étel létrehozása', ['create'], ['class' => 'btn btn-success']) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label'  => 'Étel',
                'value'  => function ($data, $id, $index, $dataColumn) {
                    return $data->translate('hu-HU')->name;
                },
                'format' => 'raw',
            ],

            'id',
            'category',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
