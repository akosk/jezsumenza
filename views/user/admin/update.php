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
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View                 $this
 * @var dektrium\user\models\User    $user
 * @var dektrium\user\models\Profile $profile
 * @var dektrium\user\Module         $module
 */

$this->title = Yii::t('user', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@dektrium/user/views/_alert', [
    'module' => Yii::$app->getModule('user'),
]) ?>




<?php if ($user->getIsBlocked()): ?>
    <div class="alert alert-danger">
        <?= Yii::t('user', 'Blocked at {0, date, MMMM dd, YYYY HH:mm}', [$user->blocked_at]) ?>
    </div>
<?php endif;?>


<div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab"
                                                  data-toggle="tab">Profil</a></li>
        <li role="presentation"><a href="#rbac" aria-controls="rbac" role="tab"
                                   data-toggle="tab">Szerepkörök</a></li>
    </ul>
    <br/><br/>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="profile">



            <?php $form = ActiveForm::begin([
                'enableAjaxValidation'   => true,
                'enableClientValidation' => false
            ]); ?>

            <div class="panel panel-default">
                <div class="panel-body">
                    <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                    <?php if (!$user->getIsConfirmed()): ?>
                        <?= Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $user->id, 'back' => 'update'], ['class' => 'btn btn-success btn-sm', 'data-method' => 'post']) ?>
                    <?php endif; ?>
                    <?php if ($user->getIsBlocked()): ?>
                        <?= Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $user->id, 'back' => 'update'], ['class' => 'btn btn-success btn-sm', 'data-method' => 'post', 'data-confirm' => Yii::t('user', 'Are you sure to block this user?')]) ?>
                    <?php else: ?>
                        <?= Html::a(Yii::t('user', 'Block'), ['block', 'id' => $user->id, 'back' => 'update'], ['class' => 'btn btn-danger btn-sm', 'data-method' => 'post', 'data-confirm' => Yii::t('user', 'Are you sure to block this user?')]) ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Html::encode($this->title) ?>
                </div>
                <div class="panel-body">
                    <?= $this->render('@dektrium/user/views/admin/_user', ['form' => $form, 'user' => $user]) ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Yii::t('user', 'Update user profile') ?>
                </div>
                <div class="panel-body">
                    <?= $this->render('@dektrium/user/views/admin/_profile', ['form' => $form, 'profile' => $profile]) ?>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-body">
                    <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                    <?php if (!$user->getIsConfirmed()): ?>
                        <?= Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $user->id, 'back' => 'update'], ['class' => 'btn btn-success btn-sm', 'data-method' => 'post']) ?>
                    <?php endif; ?>
                    <?php if ($user->getIsBlocked()): ?>
                        <?= Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $user->id, 'back' => 'update'], ['class' => 'btn btn-success btn-sm', 'data-method' => 'post', 'data-confirm' => Yii::t('user', 'Are you sure to block this user?')]) ?>
                    <?php else: ?>
                        <?= Html::a(Yii::t('user', 'Block'), ['block', 'id' => $user->id, 'back' => 'update'], ['class' => 'btn btn-danger btn-sm', 'data-method' => 'post', 'data-confirm' => Yii::t('user', 'Are you sure to block this user?')]) ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="rbac">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Szerepkörök
                </div>
                <div class="panel-body">
                    <?= \dektrium\rbac\widgets\Assignments::widget([
                        'userId' => $user->id,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

</div>

