<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
?>
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
        ]
    ]
]) ?>
</div>
