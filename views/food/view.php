<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Food */

$this->title = 'Megtekintés';
$this->params['breadcrumbs'][] = ['label' => 'Ételek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-view">

    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('kitchener')) { ?>
    <h1><?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Módosítás', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Létrehozás', ['create', 'id' => $model->id], ['class'
                                                                                                            => 'btn btn-primary']) ?>

        <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Törlés', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Biztosan törölni szeretné?',
                'method'  => 'post',
            ],
        ]) ?></h1>
    <?php } ?>

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
            [
                'label'=>'Kép',
                'format' => 'raw',
                'attribute' => 'image',
                'value'     => "<img class='img-responsive' src='/images/foods/{$model->image}'>"

            ],

        ],
    ]) ?>

</div>
