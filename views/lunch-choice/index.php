<?php
/* @var $this yii\web\View */

use app\components\DateHelper;
use yii\helpers\Url;

$this->title = 'Menü választó';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "$date";

$this->registerJs('var baseUrl="' . \yii\helpers\Url::home(true) . '";', \yii\web\View::POS_HEAD);
$this->registerJs('var selectUrl="' . \yii\helpers\Url::toRoute('select') . '";', \yii\web\View::POS_HEAD);
$this->registerJsFile(\yii\helpers\Url::base(true) . '\js\lunch-choice-index.js', [
    'depends'  => ['yii\web\YiiAsset'],
    'position' => \yii\web\View::POS_END
]);
?>


    <div class="row" style="margin-bottom:20px">
        <div class="col-xs-6 col-md-2 text-left">
            <a class="btn btn-primary" style="width:100%"
               href="<?= Url::toRoute(['/lunch-choice/index', 'date' => $previousWeek], true) ?>">
                <i class="glyphicon glyphicon-arrow-left"></i>
                Előző hét
            </a>
        </div>
        <div class="col-xs-6 col-md-2 col-md-offset-8 text-right">
            <a class="btn btn-primary" style="width:100%"
               href="<?= Url::toRoute(['/lunch-choice/index', 'date' => $nextWeek], true) ?>">
                Következő hét
                <i class="glyphicon glyphicon-arrow-right"></i>
            </a>
        </div>
    </div>


<?php if (!empty($lunchMenus)) { ?>
    <div id="menu-week">

        <?php foreach ($lunchMenus as $key => $daylyMenus) { ?>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="glyphicon glyphicon-calendar"></i> <?=
                        DateHelper::getDayWithDayName($key) ?></h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <?php foreach ($daylyMenus as $menu) {
                            $userSelected = in_array($menu->id, $userChoices);
                            ?>
                            <div class="col-xs-6 col-sm-4  text-center">
                                <h4> '<?= $menu->letter ?>' menü</h4>
                                <?php foreach ($menu->foods as $food) { ?>
                                    <h5><?= $food->translate(Yii::$app->language)->name ?></h5>
                                <?php } ?>

                                <?php if ($key > date('Y-m-d')) { ?>
                                    <button data-user-selected="<?= $userSelected ? 1 : 0 ?>"
                                            data-menu-date="<?= $menu->date ?>"
                                            data-menu-id="<?= $menu->id ?>"
                                            class="btn btn-primary <?= $userSelected ? 'disabled' : '' ?>">
                                        <?= $userSelected ? 'Kiválasztva' : 'Ezt választom!' ?>
                                    </button>
                                <?php } else {
                                    if ($userSelected) {
                                        ?>
                                        <h3><span class="label label-primary">Kiválasztva</span></h3>
                                    <?php }
                                } ?>

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
                Erre a hétre jelenleg nincs megadva egy menü sem.
            </div>
        </div>
    </div>

<?php }