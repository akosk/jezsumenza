<?php
/* @var $this yii\web\View */

use app\components\GridView;
use yii\helpers\Html;

$this->title = 'Menüt rendelő, de nem fogyasztó tanulók';
$this->params['breadcrumbs'][] = 'Statisztika';
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'label'     => 'Időpont',
            'attribute' => 'lunch_date',
            'filterType'=>GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions'=>[
                'convertFormat'=>true,
                'pluginOptions'=>[
                    'timePicker'=>false,
                    'format'=>'Y-m-d'
                ]
            ],
            'value'     => function ($model, $key, $index, $column) {
                return $model['lunch_date'];
            }
        ],
        [
            'label'     => 'Név',
            'attribute' => 'name',
            'value'     => function ($model, $key, $index, $column) {
                return $model['name'];
            }
        ],
    ],
    'responsive'   => true,
    'hover'        => true,
    'panel'        => [
        'type'    => GridView::TYPE_PRIMARY,
        'heading' => 'Menüt rendelő de nem fogyasztó tanulók',
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




