<?php
/* @var $this yii\web\View */

use app\components\GridView;
use yii\helpers\Html;

$this->title = 'Ételek listája';
$this->params['breadcrumbs'][] = 'Statisztika';
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'label'     => 'Étel neve',
            'attribute' => 'name',
            'value'     => function ($model, $key, $index, $column) {
                return $model['name'];
            }
        ],
        [
            'label'     => 'Választások száma',
            'attribute' => 'db',
            'value'     => function ($model, $key, $index, $column) {
                return $model['db'];
            }
        ]
    ],
    'responsive'   => true,
    'hover'        => true,
    'panel'        => [
        'type'    => GridView::TYPE_PRIMARY,
        'heading' => 'Ételek listája',
    ],
    // set your toolbar
    'toolbar'      => [

        '{export}',
        '{toggleData}',
    ],
    // set export properties
    'export'       => [
        'fontAwesome' => true
    ],

]);




