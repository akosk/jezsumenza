<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.05.06.
 * Time: 16:49
 */

use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
use kartik\builder\Form;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\LunchMenu */
/* @var $form kartik\form\ActiveForm */


$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);

echo Form::widget([
    'model'      => $model,
    'form'       => $form,
    'columns'    => 2,
    'attributes' => [
        'id' => [
            'type'        => Form::INPUT_WIDGET,
            'widgetClass' => '\kartik\widgets\Select2',
            'label'=>'Felhasználó',

            'options'     => [
                'data'          => [],
                'options'       => [
                    'placeholder' => 'Válasszon felhasználót...',
                ],
                'pluginOptions' => [
                    'allowClear'         => true,
                    'minimumInputLength' => 3,
                    'ajax'               => [
                        'url'      => Url::toRoute(['/lunch-menu/search-users']),
                        'dataType' => 'json',
                        'data'     => new JsExpression('function(term,page) { return {q:term}; }'),
                        'results'  => new JsExpression('function(data,page) { return {results:data}; }'),
                    ],
                    'formatResult'=>new JsExpression('function(repo) { return "<div><strong>"+repo.name+"</strong> ("+repo.username+")</div>"; }'),
                    'formatSelection'=>new JsExpression('function(repo) { return repo.name; }'),
//                    'initSelection' => new JsExpression($initScript)
                ]
            ]
        ],

    ]

]);



?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php
ActiveForm::end();
?>




