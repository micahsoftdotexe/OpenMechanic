<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
?>
<h1> Users </h1>
<?= Html::button('Register New User', [
        'id' => 'new_user_button',
        'class' => 'btn btn-success',
        'data' => [
            'toggle' => 'modal',
            'target' => '#modalNewUser',
        ],]) //btn btn-success?>
<div id="userGrid">
<?= GridView::widget([
    'dataProvider' => $userDataProvider,
    'filterModel' => $userSearchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'username',
        'fullName',
        [
            'label' => 'Status',
            'attribute' => 'status',
            'filter' => User::getStatusList(),
            'value' => function($model) {
                return User::getStatusLabel($model->status);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{status_change}{edit}', //{edit}
            'buttons' => [
                // 'edit' => function($url, $model, $key) {
                //     return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['user/update', 'id' => $model->id], ['title' => 'Edit']);
                // },
                'status_change' => function($url, $model, $key) {
                    if ($model->status == User::STATUS_ACTIVE) {
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', ['/user/deactivate', 'id' => $model->id],
                        [
                            'title' => Yii::t('app', 'Deactivate User'),
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to deactivate this user?'),
                                'method' => 'post',
                            ],
                        ]);
                    } else {
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', ['/user/activate', 'id' => $model->id], ['title' => 'Activate']);
                    }
                },
                'edit' => function($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['user/edit', 'id' => $model->id], ['title' => 'Edit']);
                },
            ]
        ]
    ]
]) ?>
</div>
<?php
yii\bootstrap\Modal::begin([
    'id' => 'modalNewUser',
    'header' => Yii::t('app', 'Register New User'),
    'size' => yii\bootstrap\Modal::SIZE_LARGE,
]);
?>
<div class="modal-body">
    <!-- Some modal content here -->
    <div id="modalContent">
        <?= Yii::$app->controller->renderPartial('_user_sign_up', [
                'model'=> new app\models\SignupForm(),
                'edit' => false,
            ]) ?>
    </div>

</div>
<?php
    yii\bootstrap\Modal::end();


