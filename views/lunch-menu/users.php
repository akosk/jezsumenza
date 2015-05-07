<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.05.06.
 * Time: 8:45
 */


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lunch Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lunch-menu-index">

    <h1><?=$model->date?> '<?=$model->letter?>' menü</h1>

    <p>
        <?= Html::a('Felhasználó hozzáadása', ['add-user-to-menu', 'id'=>$model->id], ['class' => 'btn btn-success']) ?>
        <button onclick="deleteSelected()" class="btn btn-danger">Kijelöltek törlése</button>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            'user.username',
            'user.profile.name',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons'  => [
                    'delete' => function ($url, $model) {
                        $url = \yii\helpers\Url::to(
                            [
                                '/lunch-menu/delete-selection',
                                'user_id'       => $model->user_id,
                                'lunch_menu_id' => $model->lunch_menu_id
                            ]);
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>', $url, [
                            'class' => '',
                            'title' => Yii::t('yii', 'Törlés'),
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
        var user_ids = ids.map(function(item) {
            return item.user_id;
        });
        window.location.href = '<?php echo Url::to(['/lunch-menu/bulk-delete-choices']); ?>?lunch_menu_id=' +
        <?=$model->id?>+'&user_ids='+user_ids;
    }
</script>