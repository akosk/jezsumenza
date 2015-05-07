<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lunch Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lunch-menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Lunch Menu', ['create'], ['class' => 'btn btn-success']) ?>
        <button onclick="deleteSelected()" class="btn btn-danger">Kijelöltek törlése</button>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'letter',
            'date',
            'create_time',

            [
                'class'          => 'yii\grid\ActionColumn',
                'template'       => '{users} {view} {update} {delete}',
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
        window.location.href='<?php echo Url::to(['/lunch-menu/bulk-delete']); ?>?ids='+ids.join();
    }
</script>