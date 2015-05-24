<?php
/* @var $this yii\web\View */

$this->registerJs('var BASE_URL="' . \yii\helpers\Url::home(true) . '";', \yii\web\View::POS_HEAD);
$this->registerJs('var TEMPLATE_URL="' . \yii\helpers\Url::base(true) . '/js/templates/";', \yii\web\View::POS_HEAD);
$this->registerJs('var GATE_ID=2;', \yii\web\View::POS_HEAD);

$this->title = 'Második kapu';
$this->params['breadcrumbs'][] = $this->title;
?>

<div ng-app="gate" ng-view>
</div>
