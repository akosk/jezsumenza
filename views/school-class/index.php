<?php

use yii\helpers\Html;
use app\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SchoolClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Osztályok';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-class-index">

    <?php if (Yii::$app->user->can('admin')) { ?>
        <h1><?= Html::a('<i class="glyphicon glyphicon-plus"></i> Osztály létrehozása', ['create'], ['class' => 'btn btn-success']) ?></h1>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'responsive'   => true,
        'hover'        => true,
        'panel'        => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => 'Osztályok',
        ],
        'columns'      => [

            'name',
            'eating_time_start',
            'eating_time_end',
            [
                'label' => 'Tanulók száma',
                'value' => function ($model, $key, $index, $column) {
                    return $model->profilesCount;
                }
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'min-width: 89px;'],
                'template' => Yii::$app->user->can('admin') ? '{users} {view} {update} {delete}' : '{view}',
                'buttons'  => [
                    'users' => function ($url, $model) {
                        $url = \yii\helpers\Url::to(['/school-class/add-users', 'id' => $model->id]);
                        return Html::a('<i class="glyphicon glyphicon-user"></i>', $url, [
                            'class' => '',
                            'title' => Yii::t('yii', 'Tanulók csoportos hozzáadása'),
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
