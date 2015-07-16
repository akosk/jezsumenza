<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.07.16.
 * Time: 15:21
 */


use kartik\widgets\AlertBlock;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LunchMenu */

$this->title = 'Napi menük létrehozása';
$this->params['breadcrumbs'][] = ['label' => 'Ebéd menük', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
echo AlertBlock::widget([
    'useSessionFlash' => true,
    'delay'           => false,
    'type'            => AlertBlock::TYPE_ALERT
]);
?>

<div class="lunch-menu-create">

    <div class="panel panel-primary">

        <div class="panel-heading">
            <?=$this->title?>
        </div>

        <div class="panel-body">

            <?= $this->render('_form_daily', $_params_) ?>

        </div>
    </div>
</div>
