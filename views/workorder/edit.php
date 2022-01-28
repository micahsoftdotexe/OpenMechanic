<?php

use app\models\Workorder;
use yii\helpers\Html;
?>

<?php
$this->title = Yii::t('app', 'Update Workorder: {name}', [
    'name' => \app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->firstName.' '.\app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->lastName.' - '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->make.' '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->model,
]);
?>
 <h1><?= Html::encode($this->title) ?></h1>
<?= \yii\bootstrap\Tabs::widget([
    'options' => ['id' => 'tabUpdate'],
    'items' => [
        [
            'label' => Yii::t('app', 'Customer and Automobile'),
            // 'content' => $this->render('update', [
            //     'model' => $model,
            // ])
            'content' => $this->render('_form', [
                'model' => $model,
                'update' => true
            ])
        ],
        [
            'label' => Yii::t('app', 'Parts and Labor'),
            'content' => $this->render('_form_parts_labor', [
                'model' => $model,
                'update' => true,
                'partDataProvider' => $partDataProvider,
                'laborDataProvider' => $laborDataProvider,
            ])
        ],
    ],
]); ?>