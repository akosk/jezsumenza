<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Food */

$this->title = 'Módosítás';
$this->params['breadcrumbs'][] = ['label' => 'Ételek', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Módosítás';
?>
<div class="food-update">

    <div class="panel panel-primary">

        <div class="panel-heading">
            Étel módosítása - <?=$model->name?>
        </div>

        <div class="panel-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>


        </div>
    </div>
</div>
