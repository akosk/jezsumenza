<?php

use kartik\detail\DetailView;
use app\components\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */

$this->title = 'Megtekintés';
$this->params['breadcrumbs'][] = ['label' => 'Osztályok', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="school-class-view">
    <?php if (Yii::$app->user->can('admin')) { ?>

        <h1><?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Módosítás', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Létrehozás', ['create', 'id' => $model->id], ['class'
                                                                                                                => 'btn btn-primary']) ?>

            <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Törlés', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => 'Biztosan törölni szeretné?',
                    'method'  => 'post',
                ],
            ]) ?>
        </h1>
    <?php } ?>

    <?= DetailView::widget([
        'model'          => $model,
        'condensed'      => true,
        'hover'          => true,
        'enableEditMode' => false,
        'mode'           => DetailView::MODE_VIEW,
        'panel'          => [
            'heading' => 'Osztály - ' . $model->name,
            'type'    => DetailView::TYPE_PRIMARY,
        ],
        'attributes'     => [
            'id',
            'name',
            'eating_time_start',
            'eating_time_end',
        ],
    ]) ?>


    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getProfiles(),
        ]),
//        'dataProvider' => $dataProvider,
//        'filterModel'  => $searchModel,
        'responsive'   => true,
        'hover'        => true,
        'panel'        => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => 'Tanulók',
        ],
        'columns'      => [

            'name',


        ],
    ]); ?>
</div>
