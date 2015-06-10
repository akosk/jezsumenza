<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ebéd menük';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lunch-menu-index">

    <?php if (Yii::$app->user->can('admin')) { ?>
    <h1><?= Html::a('<i class="glyphicon glyphicon-plus"></i> Ebéd menü létrehozása', ['create'], ['class' => 'btn btn-success']) ?>
        <button onclick="deleteSelected()" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i>
            Kijelöltek törlése</button>
    </h1>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'panel'        => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => 'Ebéd menük',
        ],
        'columns'      => [
            ['class' => 'yii\grid\CheckboxColumn'],

            [
                'label'     => 'Időpont',
                'attribute' => 'date',
                'filterType'=>GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions'=>[
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'timePicker'=>false,
                        'format'=>'Y-m-d'
                    ]
                ],
                'value'     => function ($model, $key, $index, $column) {
                    return $model['date'];
                }
            ],

            'letter',

            [
                'attribute'=>'foodsSorted',
                'label' => "Ételek",
                'value' => function ($data, $id, $index, $dataColumn) {
                    return implode(', ',
                        array_map(function ($item) {
                            return $item->name;
                        }, $data->foodsSorted));
                },
            ],

            [
                'class'          => 'yii\grid\ActionColumn',
                'template'       => '{users} {view} {update} {delete}',
                'template' => Yii::$app->user->can('admin') ? '{users} {view} {update} {delete}':'{users} {view}',
                'contentOptions' => ['style' => 'min-width: 69px;'],
                'buttons'        => [
                    'users' => function ($url, $model) {
                        $url = \yii\helpers\Url::to(['/lunch-menu/users', 'id' => $model->id]);
                        return Html::a('<i class="glyphicon glyphicon-user"></i>', $url, [
                            'class' => '',
                            'title' => Yii::t('yii', 'Menü választások'),
                        ]);
                    },
                ]
            ],

        ],
    ]); ?>

</div>

<script>
    function getSelectedRows() {
        return $('#w0').yiiGridView('getSelectedRows');
    }

    function deleteSelected() {
        var ids = getSelectedRows();
        window.location.href = '<?php echo Url::to(['/lunch-menu/bulk-delete']); ?>?ids=' + ids.join();
    }
</script>