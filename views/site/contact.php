<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.10.07.
 * Time: 11:27
 */

use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

use kartik\form\ActiveForm;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Ötletbörze';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">


    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Köszönjük az üzenetét! Igyekszünk mihamarabb válaszolni rá.
        </div>



    <?php else: ?>

        <h4 class="text-center alert alert-info">

            Ha valami nem tetszik az oldalon, vagy van rá ötleted mivel lehetne még jobbá varázsolni, ne habozz
            megosztani velünk!

        </h4>


        <div class="row">
            <div class="col-lg-2 text-center">
                <img style="" class="img-responsive" src="/images/thinking.jpg" alt=""/>
            </div>
            <div class="col-lg-10 col-sm-12">
                <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'contact-form']);

                echo Form::widget([
                    'model'      => $model,
                    'form'       => $form,
                    'columns'    => 2,
                    'attributes' => [
                        'name'  => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Név...']],
                        'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'E-mail...']],
                    ]

                ]);

                echo Form::widget([
                    'model'      => $model,
                    'form'       => $form,
                    'columns'    => 1,
                    'attributes' => [
                        'subject' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Tárgy...']],
                    ]

                ]);

                echo Form::widget([
                    'model'      => $model,
                    'form'       => $form,
                    'columns'    => 1,
                    'attributes' => [
                        'body' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Üzenet...']],
                    ]

                ]);

                ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3 text-right">{image}</div><div class="col-lg-3">{input}</div></div>',
                ]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Elküldöm', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>

    <?php endif; ?>
</div>
