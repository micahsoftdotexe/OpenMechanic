<?php

use app\models\Workorder;
use yii\helpers\Html;
?>

<?= \yii\bootstrap\Tabs::widget([
    'options' => ['id' => 'tabUpdate'],
    'items' => [
        [
            'label' => Yii::t('app', 'Customer and Automobile'),
            'content' => $this->render('update', [
                'model' => $model,
            ])
            ],
    ],
]); ?>