<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LunchMenu */

$this->title = 'Módosítás';
$this->params['breadcrumbs'][] = ['label' => 'Ebéd menük', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => "$model->date '$model->letter' menü",
    'url'   => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Módosítás';
?>
<div class="lunch-menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', $_params_) ?>

</div>
