<?php

use yii\helpers\Html;

?>

<?php
$this->title = Yii::t('app', 'Admin Dashboard');
?>
<h1><?= Html::encode($this->title) ?></h1>
<?= \yii\bootstrap\Tabs::widget([
    'options' => ['id' => 'tabAdmin'],
    'items' => [
        [
            'label' => Yii::t('app', 'System'),
            'options' => ['id' => 'tabSystem'],
            'linkOptions' => ['id' => 'tabSystemLink'],
            'active' => $tab == 'tabSystemLink',
            'content' => $this->render('_system', [
                'systemData' => null ,
            ])
        ],
        [
            'label' => Yii::t('app', 'Users'),
            'options' => ['id' => 'tabUsers'],
            'linkOptions' => ['id' => 'tabUsersLink'],
            'active' => $tab == 'tabUsersLink',
            'content' => $this->render('_users', [
                'userDataProvider' => $userDataProvider,
                'userSearchModel' => $userSearchModel,
            ])
        ],
    ],
]); ?>