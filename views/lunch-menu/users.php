<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.05.06.
 * Time: 8:45
 */


use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menüt választó felhasználók';
$this->params['breadcrumbs'][] = ['label' => 'Ebéd menük', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => "$model->date '$model->letter' menü",
    'url'   => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lunch-menu-index">

    <h1><?= Html::a('<i class="glyphicon glyphicon-plus"></i> Felhasználó hozzáadása', ['add-user-to-menu', 'id'=>$model->id], ['class' => 'btn btn-success']) ?>
        <button onclick="deleteSelected()" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Kijelöltek
            törlése</button></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel'        => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => "$model->date '$model->letter' menü-t választó felhasználók",
        ],
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