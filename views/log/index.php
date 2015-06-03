<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Napló';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'panel'        => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => 'Napló',
        ],
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'log_time',
                'label'     => 'Időpont',
                'value'     => function ($data, $id, $index, $dataColumn) {
                    $time = new DateTime();
                    $time->setTimestamp(explode('.', $data->log_time)[0]);
                    return $time->format('Y-m-d H:m:s');
                }

            ],
            [
                'attribute' => 'user.profile.name',
                'label' => 'Név',
                'value' => function ($data, $id, $index, $dataColumn) {
                    return $data->user->profile->name;
                }

            ],
            'message:ntext',

        ],
    ]); ?>

</div>