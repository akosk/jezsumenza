<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */

$this->title = 'Megtekintés';
$this->params['breadcrumbs'][] = ['label' => 'Osztályok', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="school-class-view">

    <h1><?= Html::a('Módosítás', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Törlés', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Biztosan törölni szeretné?',
                'method' => 'post',
            ],
        ]) ?>
    </h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'eating_time_start',
            'eating_time_end',
        ],
    ]) ?>

</div>
