<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Food */

$this->title = 'Étel létrehozása';
$this->params['breadcrumbs'][] = ['label' => 'Ételek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-create">

    <div class="panel panel-primary">

        <div class="panel-heading">
            Étel létrehozása
        </div>

        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
