<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */

$this->title = 'Osztály létrehozása';
$this->params['breadcrumbs'][] = ['label' => 'Osztályok', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-class-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
