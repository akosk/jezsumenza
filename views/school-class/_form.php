<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */
/* @var $form kartik\form\ActiveForm */
?>




<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
echo Form::widget([
    'model'      => $model,
    'form'       => $form,
    'columns'    => 2,
    'attributes' => [
        'name'       => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Osztály neve...']],
        'time_range' => [
            'label'      => 'Étkezési idősáv',
            'attributes' => [
                'eating_time_start' => [
                    'type'        => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\TimePicker',

                    'options'     => [
                        'options'       => ['placeholder' => 'Időponttól...',
                        ],
                        'pluginOptions' => [
                            'showSeconds'  => false,
                            'showMeridian' => false,
                        ]

                    ],
                ],
                'eating_time_end'   => [
                    'type'        => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\TimePicker',
                    'options'     => [
                        'options'       => ['placeholder' => 'Időpontig...'],
                        'pluginOptions' => [
                            'showSeconds'  => false,
                            'showMeridian' => false,
                        ]]
                ],
            ]
        ]
    ]
]);

?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Mentés' : 'Mentés', ['class' => $model->isNewRecord ? 'btn
    btn-success' : 'btn btn-success']) ?>
</div>
<?php
ActiveForm::end();
?>


