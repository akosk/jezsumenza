<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */
/* @var $form kartik\form\ActiveForm */
?>


<?php


$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
echo Form::widget([
    'model'      => $model,
    'form'       => $form,
    'columns'    => 2,
    'attributes' => [
        'name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Osztály neve...']],
        'time_range'=>[
            'label'      => 'Time Range',
            'attributes' => [
                'eating_time_start' => [
                    'type'        => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\TimePicker',
                    'options'     => ['options' => ['placeholder' => 'Időponttól...']],
                ],
                'eating_time_end'   => [
                    'type'        => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\TimePicker',
                    'options'     => ['options' => ['placeholder' => 'Időpontig...']]
                ],
            ]
        ]
    ]
]);

?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php
ActiveForm::end();
?>


