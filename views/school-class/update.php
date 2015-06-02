<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */

$this->title = 'Módosítás';
$this->params['breadcrumbs'][] = ['label' => 'Osztályok', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Módosítás';
?>
<div class="school-class-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
