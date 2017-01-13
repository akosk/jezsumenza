<?php

use kartik\detail\DetailView;
use app\components\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolClass */

$this->title = 'Megtekintés';
$this->params['breadcrumbs'][] = ['label' => 'Osztályok', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="school-class-view">
    <?php if (Yii::$app->user->can('admin')) { ?>

        <h1><?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Módosítás', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Létrehozás', ['create', 'id' => $model->id], ['class'
                                                                                                                => 'btn btn-primary']) ?>

            <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Törlés', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => 'Biztosan törölni szeretné?',
                    'method'  => 'post',
                ],
            ]) ?>
        </h1>
    <?php } ?>

    <?= DetailView::widget([
        'model'          => $model,
        'condensed'      => true,
        'hover'          => true,
        'enableEditMode' => false,
        'mode'           => DetailView::MODE_VIEW,
        'panel'          => [
            'heading' => 'Osztály - ' . $model->name,
            'type'    => DetailView::TYPE_PRIMARY,
        ],
        'attributes'     => [
            'id',
            'name',
            'eating_time_start',
            'eating_time_end',
        ],
    ]) ?>


    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getProfiles(),
        ]),
//        'dataProvider' => $dataProvider,
        'filterModel'  => null,
        'responsive'   => true,
        'hover'        => true,
        'panel'        => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => 'Tanulók',
        ],
        'columns'      => [
            [
                'attribute' => 'name',
                'value'     => function ($data, $id, $index, $dataColumn) {
                    return $data->htmlName();
                },
                'format'    => 'raw',
            ],
            [
                'label' => 'Aktív',
                'attribute' => 'user_inactive',
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
                    if ($model->user->inactive) {
                        return Html::a('Aktiválás', ['/user/admin/inactive', 'id' => $model->user->id, 'back'=>'schoolclass'], [
                            'class' => 'btn btn-xs btn-success btn-block',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('user', 'Biztosan aktiválni szeretnéd a felhasználót?')
                        ]);
                    } else {
                        return Html::a('Inaktiválás', ['/user/admin/inactive', 'id' => $model->user->id, 'back'=>'schoolclass'], [
                            'class' => 'btn btn-xs btn-danger btn-block',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('user', 'Biztosan inaktiválni szeretnéd a felhasználót?')
                        ]);
                    }
                },
                'format' => 'raw',
                'visible' => Yii::$app->user->can('admin')
            ],
        ],
    ]); ?>
</div>
