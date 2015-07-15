<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.07.09.
 * Time: 15:56
 */


use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SchoolClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tanulók csoportos hozzáadása';
$this->params['breadcrumbs'][] = $schoolClass->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-class-index">

    <?php if (Yii::$app->user->can('admin')) { ?>
        <h1>
            <button onclick="addSelectedUsers()" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>
                Kijelöltek hozzáadása</button>
        </h1>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'responsive'   => true,
        'hover'        => true,
        'panel'        => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => "Tanulók csoportos hozzáadása a(z) {$schoolClass->name} osztályhoz"
        ],
        'columns'      => [
            [
                'class'=>'kartik\grid\CheckboxColumn',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
            'username',
            [
                'label'     => 'Név',
                'attribute' => 'profile_name',
                'value'     => function ($model, $key, $index, $column) {
                    return $model->profile->name;
                }
            ],


//            [
//                'class'    => 'yii\grid\ActionColumn',
//                'contentOptions' => ['style' => 'min-width: 89px;'],
//                'template' => Yii::$app->user->can('admin') ? '{users} {view} {update} {delete}' : '{view}',
//                'buttons'  => [
//                    'users' => function ($url, $model) {
//                        $url = \yii\helpers\Url::to(['/school-class/add-users', 'id' => $model->id]);
//                        return Html::a('<i class="glyphicon glyphicon-user"></i>', $url, [
//                            'class' => '',
//                            'title' => Yii::t('yii', 'Tanulók csoportos hozzáadása'),
//                        ]);
//                    },
//                ]
//            ],
        ],
    ]); ?>

</div>


<script>
    function getSelectedRows() {
        return $('#w0').yiiGridView('getSelectedRows');
    }

    function addSelectedUsers() {
        var ids = getSelectedRows();
        window.location.href = '<?php echo Url::to(['/school-class/add-users-xhr']);
        ?>?school_class_id=<?=$schoolClass->id?>&ids=' +
        ids.join();
    }
</script>