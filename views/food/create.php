<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Food */

$this->title = 'Étel létrehozása';
$this->params['breadcrumbs'][] = ['label' => 'Ételek', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
