<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        body {
            background-image: url('/images/bg.jpg');
            background-position: left bottom;
            background-repeat: repeat-x
        }
    </style>
</head>
<body>

<?php $this->beginBody() ?>


<div class="container">
    <div class="row">
        <div class="col-md-12 text-center" style="color: wheat">
            <h2><i class="glyphicon glyphicon-cutlery"></i> Menza</h2>

            <p class="text-muted">Fényi Gyula Jezsuita Gimnázium és Kollégium</p>
        </div>
    </div>

    <?= $content ?>

    <div class="row">
        <div class="col-md-12 text-center text-info">
            <i class="glyphicon glyphicon-question-sign"></i> Ha kérdésed van, keresd Kovács Attilát!
        </div>
    </div>
</div>


<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>
