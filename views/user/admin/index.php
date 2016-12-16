<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use app\components\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var dektrium\user\models\UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
?>


<?php if (Yii::$app->user->can('admin')) { ?>
    <h1><?= Html::a('<i class="glyphicon glyphicon-plus"></i> Felhasználó létrehozása', ['create'], ['class' => 'btn
btn-success']) ?></h1>
<?php } ?>



<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('user'),
]) ?>

<?php Pjax::begin() ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => "{items}\n{pager}",
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => 'Felhasználók',
    ],
    'columns' => [
        'username',
        [
            'label' => 'Név',
            'attribute' => 'profile_name',
            'value' => function ($model, $key, $index, $column) {
                return $model->profile->name;
            }
        ],
        'email:email',
        [
            'label' => 'Yami id',
            'attribute' => 'profile_yami_id',
            'value' => function ($model, $key, $index, $column) {
                return $model->profile->yami_id;
            }
        ],
        [
            'label' => 'Kártyaazonosító',
            'attribute' => 'profile_barcode',
            'value' => function ($model, $key, $index, $column) {
                return $model->profile->barcode;
            }
        ],
        [
            'label' => 'Szerepkör',
            'attribute' => 'role_name',
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => [
                    '' => 'Nincs szűrés',
                    'admin' => 'Adminisztrátor',
                    'economic' => 'Gazdasági csoport',
                    'kitchener' => 'Konyhafőnök',
                    'teacher' => 'Tanár',
                    'student' => 'Tanuló',
                ],
                'options' => ['multiple' => false]
            ],
            'value' => function ($model, $key, $index, $column) {
                return Yii::t('app', $model->role->itemName->description);
            }
        ],
        [
            'label' => 'Aktív',
            'attribute' => 'inactive',
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'data' => [
                    '' => 'Nincs szűrés',
                    '1' => 'Inaktív',
                    '0' => 'Aktív',
                ],
                'options' => ['multiple' => false]
            ],
            'value' => function ($model) {
                if ($model->inactive) {
                    return Html::a('Aktiválás', ['inactive', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Biztosan aktiválni szeretnéd a felhasználót?')
                    ]);
                } else {
                    return Html::a('Inaktiválás', ['inactive', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-danger btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Biztosan inaktiválni szeretnéd a felhasználót?')
                    ]);
                }
            },
            'format' => 'raw',
            'visible' => Yii::$app->user->can('admin')
        ],

//        [
//            'attribute' => 'registration_ip',
//            'value' => function ($model) {
//                    return $model->registration_ip == null
//                        ? '<span class="not-set">' . Yii::t('user', '(not set)') . '</span>'
//                        : $model->registration_ip;
//                },
//            'format' => 'html',
//        ],
//        [
//            'attribute' => 'created_at',
//            'value' => function ($model) {
//                return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
//            }
//        ],
        [
            'header' => Yii::t('user', 'Confirmation'),
            'value' => function ($model) {
                if ($model->isConfirmed) {
                    return '<div class="text-center"><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span></div>';
                } else {
                    return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure to confirm this user?'),
                    ]);
                }
            },
            'format' => 'raw',
            'visible' => Yii::$app->getModule('user')->enableConfirmation
        ],
        [
            'header' => Yii::t('user', 'Block status'),
            'value' => function ($model) {
                if ($model->isBlocked) {
                    return Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure to unblock this user?')
                    ]);
                } else {
                    return Html::a('<i class="glyphicon glyphicon-ban-circle"></i> Tiltás', ['block', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-danger btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure to block this user?')
                    ]);
                }
            },
            'format' => 'raw',
            'visible' => Yii::$app->user->can('admin')
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => [
                'style' => 'min-width:70px'
            ],

            'template' => Yii::$app->user->can('admin') ? '{payment} {update} {delete}' : '{payment}',
            'buttons' => [
                'payment' => function ($url, $model, $key) {
                    return Html::a('<i class="glyphicon glyphicon-usd"></i>', $url, [
                        'title' => 'Befizetések',
                    ]);
                }
            ]
        ],
    ],
]); ?>

<?php Pjax::end() ?>
