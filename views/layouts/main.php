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
                'label'   => '<i class="glyphicon glyphicon-wrench"></i> Adminisztráció',
                'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('kitchener') ||
                    Yii::$app->user->can('economic'),
                'items'   => [
                    [
                        'label'   => 'Felhasználók',
                        'url'     => ['/user/admin'],
                        'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('economic')],
//                    ['label' => 'Rbac', 'url' => ['/rbac/role']],
                    [
                        'label'   => 'Osztályok',
                        'url'     => ['/school-class'],
                        'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('economic')
                    ],
                    [
                        'label'   => 'Ételek',
                        'url'     => ['/food'],
                        'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('kitchener') ||
                            Yii::$app->user->can('economic')
                    ],
                    [
                        'label'   => 'Ebéd menü',
                        'url'     => ['/lunch-menu'],
                        'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('kitchener')
                            || Yii::$app->user->can('economic')
                    ],
                    [
                        'label'   => 'Első kapu',
                        'url'     => ['/gate/gate-one'],
                        'visible' => Yii::$app->user->can('admin')
                    ],
                    [
                        'label'   => 'Második kapu',
                        'url'     => ['/gate/gate-two'],
                        'visible' => Yii::$app->user->can('admin')
                    ],
                    [
                        'label'   => 'Napló',
                        'url'     => ['/log'],
                        'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('economic')
                    ],
                    [
                        'label'   => 'Befizetések importálása',
                        'url'     => ['/import'],
                        'visible' => Yii::$app->user->can('admin')
                    ],

                ]
            ],
            [
                'label'   => '<i class="glyphicon glyphicon-stats"></i> Statisztika',
                'visible' => Yii::$app->user->can('admin') || Yii::$app->user->can('kitchener') ||
                    Yii::$app->user->can('economic'),
                'items'   => [
                    [
                        'label' => 'Ételek listája',
                        'url' => ['/statistics/foods']
                    ],
                    [
                        'label' => 'Problémás tanulók',
                        'url' => ['/statistics/problematic-students']
                    ],
                    [
                        'label' => 'Menüt rendelő, de nem fogyasztó tanulók',
                        'url' => ['/statistics/missed-lunch']
                    ],
                    [
                        'label' => 'Menüt nem rendelő tanulók',
                        'url' => ['/statistics/no-order']
                    ],

                ]
            ],
            [
                'label'   => '<i class="glyphicon glyphicon-list"></i> '.Yii::t('app','Lunch choice'),
                'url'     => ['/lunch-choice'],
                'visible' => !Yii::$app->user->isGuest,
            ],

            [
                'label'   => '<i class="glyphicon glyphicon-bullhorn"></i> '.Yii::t('app','Ideas'),
                'url'     => ['/site/contact'],
            ],

            Yii::$app->user->isGuest ?
                ['label' => '<i class="glyphicon glyphicon-log-in"></i> Bejelentkezés', 'url' => ['/user/security/login']] :
                ['label'       => '<i class="glyphicon glyphicon-off"></i> Kijelentkezés (' . Yii::$app->user->identity->username . ')',
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
