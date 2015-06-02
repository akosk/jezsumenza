<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Menü választó';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('var baseUrl="' . \yii\helpers\Url::home(true) . '";', \yii\web\View::POS_HEAD);
$this->registerJs('var selectUrl="' . \yii\helpers\Url::toRoute('select') . '";', \yii\web\View::POS_HEAD);
$this->registerJsFile(\yii\helpers\Url::base(true) . '\js\lunch-choice-index.js', [
    'depends'  => ['yii\web\YiiAsset'],
    'position' => \yii\web\View::POS_END
]);
?>

    <div class="row">
        <div class="col-xs-6 text-left">
            <a class="btn btn-primary"
               href="<?= Url::toRoute(['/lunch-choice/index', 'date' => $previousWeek], true) ?>">Előző hét</a>
        </div>
        <div class="col-xs-6 text-right">
            <a class="btn btn-primary"
               href="<?= Url::toRoute(['/lunch-choice/index', 'date' => $nextWeek], true) ?>">Következő hét</a>
        </div>
    </div>

<?php if (!empty($lunchMenus)) { ?>
    <div id="menu-week">

        <?php foreach ($lunchMenus as $key => $daylyMenus) { ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3><?= $key ?></h3>
                </div>
            </div>
            <div class="row">
                <?php foreach ($daylyMenus as $menu) {
                    $userSelected = in_array($menu->id, $userChoices);
                    ?>
                    <div class="col-sm-4 text-center">
                        <h4> '<?= $menu->letter ?>' menü</h4>
                        <?php foreach ($menu->foods as $food) { ?>
                            <h5><?= $food->translate(Yii::$app->language)->name ?></h5>
                        <?php } ?>
                        <button data-user-selected="<?= $userSelected ? 1 : 0 ?>"
                                data-menu-date="<?= $menu->date ?>"
                                data-menu-id="<?= $menu->id ?>"
                                class="btn btn-primary <?= $userSelected ? 'disabled' : '' ?>">
                            <?= $userSelected ? 'Kiválasztva' : 'Ezt választom!' ?>
                        </button>
                    </div>
                <?php } ?>
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