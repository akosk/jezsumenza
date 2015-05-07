<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */
use app\models\SchoolClass;
use kartik\widgets\TimePicker;
use yii\helpers\ArrayHelper;

?>

<?= $form->field($profile, 'name') ?>
<?= $form->field($profile, 'public_email') ?>
<?= $form->field($profile, 'website') ?>
<?= $form->field($profile, 'location') ?>
<?= $form->field($profile, 'gravatar_email') ?>
<?= $form->field($profile, 'dina_id') ?>
<?= $form->field($profile, 'bio')->textarea() ?>
<?= $form->field($profile, 'school_class_id')
    ->dropDownList(ArrayHelper::map(SchoolClass::find()->orderBy('name')->all(), 'id', 'name'),
        ['prompt' => 'Válasszon osztályt...']) ?>


<label>Eating Start Time</label>
<?= TimePicker::widget([
    'name'          => 'Profile[eating_time_start]',
    'pluginOptions' => [
        'showSeconds' => false
    ]
]);?>

<label>Eating End Time</label>
<?= TimePicker::widget([
    'name'          => 'Profile[eating_time_end]',
    'pluginOptions' => [
        'showSeconds' => false
    ]
]);?>

<?= $form->field($profile, 'barcode') ?>