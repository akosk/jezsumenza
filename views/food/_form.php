<?php

use app\models\Language;
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

        <?php foreach (Language::$languages as $key => $language) { ?>
            <li class="<?= Yii::$app->language == $language['code'] ? 'active' : '' ?>">
                <a href="#panel-<?= $key ?>" aria-controls="home" role="tab" data-toggle="tab">
                    <?= Flags::widget([
                        'flag'      => $key,
                        'type'      => Flags::FLAT_48,
                        'useSprite' => false // use sprite image? default is false
                    ]); ?><br/> <?= $language['name'] ?></a>
            </li>
        <?php } ?>
    </ul>

    <div class="food-form">

        <?php $form = ActiveForm::begin(); ?>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php foreach (Language::$languages as $key => $language) {
                $code = $language['code'];
                ?>

                <div role="tabpanel" class="tab-pane <?= Yii::$app->language == $language['code'] ? 'active' : '' ?>"
                     id="panel-<?= $key ?>">
                    <?= $form->field($model->translate($code), "[$code]name")->textInput() ?>
                    <?= $form->field($model->translate($code), "[$code]description")->textarea() ?>
                </div>
            <?php } ?>

        </div>


        <?= $form->field($model, 'category')->dropDownList(['MAIN_COURSE' => 'MAIN COURSE', 'SOUP' => 'SOUP',], ['prompt' => '']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
