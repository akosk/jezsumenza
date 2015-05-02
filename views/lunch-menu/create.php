<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LunchMenu */

$this->title = 'Create Lunch Menu';
$this->params['breadcrumbs'][] = ['label' => 'Lunch Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lunch-menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', $_params_) ?>

</div>
