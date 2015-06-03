<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */

$this->title = 'Osztály létrehozása';
$this->params['breadcrumbs'][] = ['label' => 'Osztályok', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-class-create">

    <div class="panel panel-primary">

        <div class="panel-heading">
            Osztály létrehozása
        </div>

        <div class="panel-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
