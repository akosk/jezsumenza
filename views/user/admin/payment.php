<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.06.10.
 * Time: 11:42
 */

use yii\helpers\Html;
use app\components\GridView;

/* @var $this yii\web\View */

$this->title = 'Befizetések';

$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Manage users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $user->profile->name == '' ? $user->username : $user->profile->name;
//$this->params['breadcrumbs'][] = ['label' => $user->profile->name == '' ? $user->username : $user->profile->name,
//                                  'url' => ['view','id'=>$user->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-index">



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'panel'        => [
            'type'    => GridView::TYPE_PRIMARY,
            'heading' => 'Befizetések',
        ],
        'columns'      => [

            'year',
            'month',
            'amount'

        ],
    ]); ?>

</div>
