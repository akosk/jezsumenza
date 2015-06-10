<?php
/* @var $this yii\web\View */

use kartik\widgets\ActiveForm;
use kartik\widgets\AlertBlock;
use kartik\widgets\FileInput;
use yii\grid\GridView;

$this->title = 'Befizetések importálása';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-primary">
    <div class="panel-heading">
        Befizetések importálása
    </div>
    <div class="panel-body">

        <div class="alert alert-info">Az importáláshoz tallóza ki a befizetéseket tartalmazó JSON fájlt.
            Mindig az utoljára importált fájl tartalma a mérvadó.</div>

        <?php

        $form1 = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'] // important
        ]);

        echo FileInput::widget([
            'name'          => 'attachment',
            'pluginOptions' => [
                'removeLabel'   => 'Eltávolítás',
                'browseLabel'   => 'Tallózás',
                'uploadLabel'   => 'Feltöltés',
                'elCaptionText' => '#customCaption'
            ]
        ]);

        ActiveForm::end();
        ?>
    </div>
</div>


<?php
echo AlertBlock::widget([
    'useSessionFlash' => true,
    'delay'           => false,
    'type'            => AlertBlock::TYPE_ALERT
]);
?>

