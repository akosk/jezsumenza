<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LunchMenu */

$this->title = 'Megtekintés';
$this->params['breadcrumbs'][] = ['label' => 'Ebéd menük', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => "$model->date '$model->letter' menü",
    'url'   => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lunch-menu-view">

    <h1> <?= Html::a('Módosítás', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Törlés', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Biztosan törölni szeretné?',
                'method' => 'post',
            ],
        ]) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'condensed'      => true,
        'hover'          => true,
        'enableEditMode' => false,
        'mode'           => DetailView::MODE_VIEW,
        'panel'          => [
            'heading' => "Ebéd menü - {$model->date} '{$model->letter}' menü",
            'type'    => DetailView::TYPE_PRIMARY,
        ],

        'attributes' => [
            'id',
            'letter',
            'date',
            [
                'label'=>'Ételek',
                'format'=>'raw',
                'value'=> implode(', ',array_map ( function($item) {
                    return $item->name;
                },$model->foodsSorted)),

            ],
            'create_time',
        ],
    ]) ?>

</div>
