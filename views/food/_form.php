<?php

use yii\flags\Flags;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Food */
/* @var $form yii\widgets\ActiveForm */
?>


<div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs text-center" role="tablist">
        <li onclick="show('hu');" class="active"><a href="#profile" role="tab" data-toggle="tab">
                <?=Flags::widget([
                    'flag' => 'HU',
                    'type' => Flags::FLAT_48,
                    'useSprite' => false // use sprite image? default is false
                ]); ?><br/> Magyar</a>
        </li>
        <li onclick="show('en');"><a href="#profile" role="tab" data-toggle="tab">
                <?=Flags::widget([
                    'flag' => 'GB',
                    'type' => Flags::FLAT_48,
                    'useSprite' => false // use sprite image? default is false
                ]); ?><br/> Angol</a></li>
        <li onclick="show('hu');"><a href="#messages" role="tab" data-toggle="tab">
                <?=Flags::widget([
                    'flag' => 'DE',
                    'type' => Flags::FLAT_48,
                    'useSprite' => false // use sprite image? default is false
                ]); ?><br/> Német</a></li>
        <li onclick="show('fr');"><a href="#settings" role="tab" data-toggle="tab">
                <?=Flags::widget([
                    'flag' => 'FR',
                    'type' => Flags::FLAT_48,
                    'useSprite' => false // use sprite image? default is false
                ]); ?><br/> Francia</a></li>
        <li onclick="show('hu');"><a href="#settings" role="tab" data-toggle="tab">
                <?=Flags::widget([
                    'flag' => 'IT',
                    'type' => Flags::FLAT_48,
                    'useSprite' => false // use sprite image? default is false
                ]); ?><br/> Olasz</a></li>
    </ul>

    <div class="food-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model->translate('de_DE'), "name")->textInput() ?>
        <?= $form->field($model->translate('de_DE'), "description")->textarea() ?>

        <?= $form->field($model, 'category')->dropDownList(['MAIN_COURSE' => 'MAIN COURSE', 'SOUP' => 'SOUP',], ['prompt' => '']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>

<script>
    function show(lang) {
        alert(lang);
        console.log($('ul'));
    }
</script>