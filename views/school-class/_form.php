<?php

use app\components\DateHelper;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */
/* @var $form kartik\builder\Form */
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
                            'defaultTime'  => false
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
                            'defaultTime'  => false
                        ]]
                ],
            ]
        ]
    ]
]);


for ($i = 1; $i < 6; $i++) {
//foreach (DateHelper::$DAY_NAMES as $day) {

    echo Form::widget([
        'model'      => $model,
        'form'       => $form,
        'columns'    => 1,
        'attributes' => [
            'time_range' => [
                'label'      => 'Étkezési idősáv - ' . Yii::t('app', DateHelper::$DAY_NAMES[$i]),
                'attributes' => [
                    "eating_time_start_weekday_{$i}" => [
                        'type'        => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\TimePicker',

                        'options'     => [
                            'options'       => ['placeholder' => 'Időponttól...',
                            ],
                            'pluginOptions' => [
                                'showSeconds'  => false,
                                'showMeridian' => false,
                                'defaultTime'  => false
                            ]

                        ],
                    ],
                    "eating_time_end_weekday_{$i}"   => [
                        'type'        => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\TimePicker',
                        'options'     => [
                            'options'       => ['placeholder' => 'Időpontig...'],
                            'pluginOptions' => [
                                'showSeconds'  => false,
                                'showMeridian' => false,
                                'defaultTime'  => false
                            ]]
                    ],
                ]
            ]
        ]
    ]);
}
?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Mentés' : 'Mentés', ['class' => $model->isNewRecord ? 'btn
    btn-success' : 'btn btn-success']) ?>
</div>
<?php
ActiveForm::end();
?>


