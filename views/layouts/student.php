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
</head>
<body>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([

        'brandLabel' => '<i class="glyphicon glyphicon-cutlery"></i> Menza',
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar-default  navbar-fixed-top navbar-inverse cbp-af-header',
        ],
    ]);
    echo Nav::widget([
        'options'      => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items'        => [

            [
                'label'   => '<i class="glyphicon glyphicon-list"></i> '.Yii::t('app','Lunch choice'),
                'url'     => ['/lunch-choice'],
                'visible' => Yii::$app->user->can('student') || Yii::$app->user->can('teacher'),
            ],
            [
                'label'   => '<i class="glyphicon glyphicon-bullhorn"></i> '.Yii::t('app','Ideas'),
                'url'     => ['/site/contact'],
            ],
            Yii::$app->user->isGuest ?
                ['label' => '<i class="glyphicon glyphicon-log-in"></i> Bejelentkezés', 'url' => ['/user/security/login']] :
                ['label'       => '<i class="glyphicon glyphicon-off"></i> '.Yii::t('app','Logout').' (' .
                Yii::$app->user->identity->username . ')',
                 'url'         => ['/user/security/logout'],
                 'linkOptions' => ['data-method' => 'post']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <a href="http://www.softmaster.hu">SoftMaster Kft</a> <?= date('Y') ?></p>

    </div>
</footer>

<?php $this->endBody() ?>

<script src="<?= Url::base(); ?>/js/classie.js" type="text/javascript"></script>
<script src="<?= Url::base(); ?>/js/cbpAnimatedHeader.min.js" type="text/javascript"></script>


</body>
</html>
<?php $this->endPage() ?>
