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

    <div class="panel panel-primary">

        <div class="panel-heading">
            Ebéd menü módosítása - <?="$model->date '$model->letter' menü"?>
        </div>

        <div class="panel-body">
    <?= $this->render('_form', $_params_) ?>

</div>
</div>
</div>
