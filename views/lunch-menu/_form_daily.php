<?php
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\models\LunchMenu */
/* @var $form kartik\form\ActiveForm */

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
echo Form::widget([
    'model'      => $modelA,
    'form'       => $form,
    'columns'    => 1,
    'attributes' => [
        'date'   => [
            'type'        => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\DatePicker',
            'hint'        => 'A menü dátuma (év-hónap-nap)',
            'options'     => [
                'value'         => date('Y-m-d', strtotime('+2 days')),
                'options'       => ['placeholder' => 'Adja meg a menü dátumát ...'],
                'pluginOptions' => [
                    'format'         => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]
        ],
    ]
]);

echo Form::widget([
    'model'      => $modelA,
    'form'       => $form,
    'columns'    => 2,
    'contentBefore'=>'<h3> \'A\' menü</h3>',
    'attributes' => [
        'formFoods[0]' => [
            'type'        => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'label'=>'Étel 1.',
            'options'     => [
                'data'    => $foods,
                'options' => [
                    'placeholder' => 'Válasszon ételt...',
                ]
            ],
            'hint'        => 'Válassz az ételek közül'
        ],
        'formFoods[1]' => [
            'type'        => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'label'=>'Étel 2.',
            'options'     => [
                'data'    => $foods,
                'options' => [
                    'placeholder' => 'Válasszon ételt...',
                ]
            ],
            'hint'        => 'Válassz az ételek közül'
        ],

    ]

]);

echo Form::widget([
    'model'      => $modelB,
    'form'       => $form,
    'columns'    => 2,
    'contentBefore'=>'<h3> \'B\' menü</h3>',
    'attributes' => [
        'formFoods[2]' => [
            'type'        => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'label'=>'Étel 1.',
            'options'     => [
                'data'    => $foods,
                'options' => [
                    'placeholder' => 'Válasszon ételt...',
                ]
            ],
            'hint'        => 'Válassz az ételek közül'
        ],
        'formFoods[3]' => [
            'type'        => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'label'=>'Étel 2.',
            'options'     => [
                'data'    => $foods,
                'options' => [
                    'placeholder' => 'Válasszon ételt...',
                ]
            ],
            'hint'        => 'Válassz az ételek közül'
        ],

    ]

]);

echo Form::widget([
    'model'      => $modelC,
    'form'       => $form,
    'columns'    => 2,
    'contentBefore'=>'<h3> \'C\' menü</h3>',
    'attributes' => [

        'formFoods[4]' => [
            'type'        => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'label'=>'Étel 1.',
            'options'     => [
                'data'    => $foods,
                'options' => [
                    'placeholder' => 'Válasszon ételt...',
                ]
            ],
            'hint'        => 'Válassz az ételek közül'
        ],
        'formFoods[5]' => [
            'type'        => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'label'=>'Étel 2.',
            'options'     => [
                'data'    => $foods,
                'options' => [
                    'placeholder' => 'Válasszon ételt...',
                ]
            ],
            'hint'        => 'Válassz az ételek közül'
        ],

    ]

]);



?>
<div class="form-group">
    <?= Html::submitButton($modelA->isNewRecord ? 'Mentés' : 'Mentés', ['class' => $model->isNewRecord ? 'btn
    btn-success' : 'btn btn-success']) ?>
</div>
<?php
ActiveForm::end();
?>




