<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LunchMenu */

$this->title = 'Ebéd menü létrehozása';
$this->params['breadcrumbs'][] = ['label' => 'Ebéd menük', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lunch-menu-create">


    <?= $this->render('_form', $_params_) ?>

</div>
