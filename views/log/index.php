<?php

use yii\helpers\Html;
use app\components\GridView;

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

            [
                'attribute' => 'log_time',
                'label'     => 'Időpont',
                'filterType'=>GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=>[
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'timePicker'=>true,
                        'timePickerIncrement'=>30,
                        'format'=>'Y-m-d h:i'
                    ]
                ],
                'value'     => function ($data, $id, $index, $dataColumn) {
                    $time = new DateTime();
                    $time->setTimestamp(explode('.', $data->log_time)[0]);
                    return $time->format('Y-m-d H:m:s');
                }

            ],
            [
                'attribute' => 'user.profile.name',
                'value'     => function ($data, $id, $index, $dataColumn) {
                    return isset($data->user) && isset($data->user->profile) ? $data->user->profile->htmlName() : '';
                },
                'format'=>'raw'

            ],
            'message:ntext',

        ],
    ]); ?>

</div>
