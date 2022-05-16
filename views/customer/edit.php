<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php
$this->title = Yii::t('app', 'Update Customer: {name}', [
    'name' => \app\models\Customer::find()->where(['id'=> $model->id])->one()->first_name.' '.\app\models\Customer::find()->where(['id'=> $model->id])->one()->last_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => \app\models\Customer::find()->where(['id'=> $model->id])->one()->first_name.' '.\app\models\Customer::find()->where(['id'=> $model->id])->one()->last_name, 'url' => ['edit', 'id' => $model->id]];
// $finalizeTabCheck = ($tab == 'tabFinalizeLink') && ((\app\models\Order::$stages[$model->stage] == 'Completed') || (\app\models\Order::$stages[$model->stage] == 'Paid'));
// $finalizeCheck = ((\app\models\Order::$stages[$model->stage] == 'Completed') || (\app\models\Order::$stages[$model->stage] == 'Paid'));
?>

<?= \yii\bootstrap\Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Customer Info'),
            'content' => $this->render('_form', [
                'model' => $model,
                'tab' => 'tabCustomersLink',
                'change_form' => false
            ]),
            'active' => ($tab == 'tabCustomersLink'),
        ],
        // [
        //     'label' => Yii::t('app', 'Automobiles'),
        //     'content' => $this->render('_edit', [
        //         'model' => $model,
        //         'tab' => 'tabAutomobilesLink',
        //     ]),
        //     'active' => ($tab == 'tabAutomobilesLink'),
        // ],
        // [
        //     'label' => Yii::t('app', 'Orders'),
        //     'content' => $this->render('_edit', [
        //         'model' => $model,
        //         'tab' => 'tabOrdersLink',
        //     ]),
        //     'active' => ($tab == 'tabOrdersLink'),
        // ],
    ],
]);