<?php
/* @var $this yii\web\View */

use app\components\GridView;
use yii\helpers\Html;

$this->title = 'Problémás tanulók';
$this->params['breadcrumbs'][] = 'Statisztika';
$this->params['breadcrumbs'][] = $this->title;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'label'     => 'Időpont',
            'attribute' => 'create_time',
            'filterType'=>GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions'=>[
                'convertFormat'=>true,
                'pluginOptions'=>[
                    'timePicker'=>true,
                    'timePickerIncrement'=>30,
                    'format'=>'Y-m-d h:i'
                ]
            ],
            'value'     => function ($model, $key, $index, $column) {
                return $model['create_time'];
            }
        ],
        [
            'label'     => 'Név',
            'attribute' => 'name',
            'value'     => function ($model, $key, $index, $column) {
                return $model['name'];
            }
        ],
        [
            'label'     => 'Probléma',
            'attribute' => 'problem',
            'filterType'=>GridView::FILTER_SELECT2,
            'filterWidgetOptions'=>[
                'data' => [0=>'Nincs szűrés',1=>'Nem rendelt de mégis belépett.', 2=>'Rossz időpontban próbált belépni
                .'],
                'options' => ['multiple' => false, 'placeholder' => 'Válasszon problémát ...']
            ],


            'value'     => function ($model, $key, $index, $column) {
                $errors=[];
                if ($model['lunch_right'] != 1) $errors[]='Nem rendelt de mégis belépett.';
                if ($model['between_eating_time'] != 1) $errors[]='Rossz időpontban próbált belépni.';
                return implode(' ',$errors);
            }
        ],
    ],
    'responsive'   => true,
    'hover'        => true,
    'panel'        => [
        'type'    => GridView::TYPE_PRIMARY,
        'heading' => 'Problémás tanulók',
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




