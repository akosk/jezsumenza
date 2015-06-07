<?php

use yii\helpers\Html;
use kartik\grid\GridView;

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
        'filterModel'  => $searchModel,
        'panel'        => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => 'Ételek',
        ],
        'columns'      => [

            [
                'attribute' => 'name',
                'label'     => 'Étel',
                'value'     => function ($data, $id, $index, $dataColumn) {
                    return $data->translate('hu-HU')->name;
                },
                'format'    => 'raw',
            ],

            [
                'attribute'           => 'category',
                'filterType'          => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data'    => [
                        ' ' => 'Nincs szűrés',
                        'MAIN_COURSE' => Yii::t('app','MAIN_COURSE'),
                        'SOUP' =>Yii::t('app','SOUP')
                    ],
                    'options' => ['multiple' => false, 'placeholder' => 'Válasszon kategóriát ...']
                ],
                'value'               => function ($data, $id, $index, $dataColumn) {
                    return Yii::t('app', $data->category);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
