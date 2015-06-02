<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Food */

$this->title = 'Megtekintés';
$this->params['breadcrumbs'][] = ['label' => 'Foods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-view">

    <h1><?= Html::a('Módosítás', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Törlés', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Biztosan törölni szeretné?',
                'method' => 'post',
            ],
        ]) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category',
        ],
    ]) ?>

</div>
