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

$this->title = 'Felhasználó hozzáadása';
$this->params['breadcrumbs'][] = ['label' => 'Ebéd menük', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => "$lunchMenu->date '$lunchMenu->letter' menü",
    'url'   => ['view', 'id' => $lunchMenu->id]];
$this->params['breadcrumbs'][] = [
    'label' => "Menüt választó felhasználók",
    'url'   => ['users', 'id' => $lunchMenu->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-primary">

    <div class="panel-heading">
          <?= "{$this->title} - $lunchMenu->date '$lunchMenu->letter' menü" ?>
    </div>

    <div class="panel-body">

        <?php
        $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);

        echo Form::widget([
            'model'      => $model,
            'form'       => $form,
            'columns'    => 2,
            'attributes' => [
                'id' => [
                    'type'        => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'label'       => 'Felhasználó',

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
                                'data'     => new JsExpression('function(term,page) { console.log(term);return {q:term}; }'),
                            ],
                            'templateResult' => new JsExpression('function(user) {return user.name+" ("+user.username+")"; }'),
                            'templateSelection' => new JsExpression('function (user) {  return user.name; }')
//                    'initSelection' => new JsExpression($initScript)
                        ]
                    ]
                ],

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
    </div>
</div>



