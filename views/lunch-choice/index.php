<?php
/* @var $this yii\web\View */

use app\components\DateHelper;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Lunch choice');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "$date";

$this->registerJs('var baseUrl="' . \yii\helpers\Url::home(true) . '";', \yii\web\View::POS_HEAD);
$this->registerJs('var selectUrl="' . \yii\helpers\Url::toRoute('select') . '";', \yii\web\View::POS_HEAD);
$this->registerJsFile(\yii\helpers\Url::base(true) . '/js/lunch-choice-index.js', [
    'depends'  => ['yii\web\YiiAsset'],
    'position' => \yii\web\View::POS_END
]);

?>


<div class="row" style="margin-bottom:20px">
    <div class="col-xs-6 col-md-2 text-left">
        <a class="btn btn-primary" style="width:100%"
           href="<?= Url::toRoute(['/lunch-choice/index', 'date' => $previousWeek], true) ?>">
            <i class="glyphicon glyphicon-arrow-left"></i>
            <?= Yii::t('app', 'Previous week') ?>
        </a>
    </div>
    <div class="col-xs-6 col-md-2 col-md-offset-8 text-right">
        <a class="btn btn-primary" style="width:100%"
           href="<?= Url::toRoute(['/lunch-choice/index', 'date' => $nextWeek], true) ?>">
            <?= Yii::t('app', 'Next week') ?>
            <i class="glyphicon glyphicon-arrow-right"></i>
        </a>
    </div>
</div>


<?php if (!empty($lunchMenus)) { ?>
    <div id="menu-week">




        <?php
        reset($lunchMenus);
        $mondayOfCurrentWeek=key($lunchMenus);
        $lastWednesday=date('Y-m-d',strtotime('last wednesday', strtotime($mondayOfCurrentWeek)));

        foreach ($lunchMenus as $key => $daylyMenus) {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-calendar"></i> <?=
                        DateHelper::getDayWithDayName($key) ?></h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <?php

                        foreach ($daylyMenus as $menu) {

                            $userSelected = in_array($menu->id, $userChoices);
                            ?>
                            <div class="col-xs-6 col-sm-4  text-center">
                                <button data-user-selected="<?= $userSelected ? 1 : 0 ?>"
                                        data-menu-date="<?= $menu->date ?>"
                                        data-menu-id="<?= $menu->id ?>"
                                        class="menu-widget btn btn-primary <?= $userSelected || (date('Y-m-d')>$lastWednesday)
                                            ? 'disabled' : '' ?>"
                                        <?= $userSelected || (date('Y-m-d')>$lastWednesday)
                                        ? 'disabled="disabled"' : '' ?>
                                    >
                                    <h3>
                                        <?php if ($userSelected) { ?>
                                            <i class="glyphicon glyphicon-ok" style="color:deepskyblue"></i>
                                        <?php } ?>
                                        <strong><?= $menu->letter ?></strong></h3>
                                    <?php
                                    $description = "";
                                    foreach ($menu->foodsSorted as $food) {
                                        $description .= "<h4>{$food->name}</h4> <em>{$food->description}</em>"
                                        ?>
                                        <h5><?= $food->translate(Yii::$app->language)->name ?></h5>
                                    <?php } ?>
                                    <a onclick="
                                        event.preventDefault();
                                        event.stopPropagation();
                                        $('#modal-body').html('<?= $description ?>');
                                        $('#myModal').modal({});"><h3
                                            style="cursor:pointer;margin:0px;
                                    padding:0px;">
                                            <i class="glyphicon glyphicon-question-sign" style="color:white"></i>
                                        </h3></a>
                                </button>

                                <div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-info" role="alert">

                <?=Yii::t('app','There is no menu for this week')?>
            </div>
        </div>
    </div>

<?php }
?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= Yii::t('app', 'Food description') ?> </h4>
            </div>
            <div id="modal-body" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t('app','Close')?></button>
            </div>
        </div>
    </div>
</div>
