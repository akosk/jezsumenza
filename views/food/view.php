<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Food */

$this->title = 'Megtekintés';
$this->params['breadcrumbs'][] = ['label' => 'Foods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-view">

    <h1><?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Módosítás', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Törlés', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Biztosan törölni szeretné?',
                'method'  => 'post',
            ],
        ]) ?></h1>


    <?= DetailView::widget([
        'model'          => $model,
        'condensed'      => true,
        'hover'          => true,
        'enableEditMode' => false,
        'mode'           => DetailView::MODE_VIEW,
        'panel'          => [
            'heading' => 'Étel - ' . $model->name,
            'type'    => DetailView::TYPE_PRIMARY,
        ],
        'attributes'     => [
            'id',
            [
                'attribute' => 'category',
                'value'     => Yii::t('app', $model->category)

            ],
            'name',
            'description',
        ],
    ]) ?>

</div>
