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
    'options' => ['id' => 'tabCustomer'],
    'items' => [
        [
            'label' => Yii::t('app', 'Customer Info'),
            'options'     => ['id' => 'tabCustomer'],
            'linkOptions' => ['id' => 'tabCustomersLink'],
            'content' => $this->render('_form', [
                'model' => $model,
                //'tab' => 'tabCustomersLink',
                'change_form' => false
            ]),
            'active' => ($tab == 'tabCustomersLink'),
        ],
        [
            'label' => Yii::t('app', 'Automobiles'),
            'options'     => ['id' => 'tabAutomobiles'],
            'linkOptions' => ['id' => 'tabAutomobilesLink'],
            'content' => $this->render('_automobile_index', [
                'dataProvider' => $automobileDataProvider,
                //'tab' => 'tabAutomobilesLink',
            ]),
            'active' => ($tab == 'tabAutomobilesLink'),
        ],
        [
            'label' => Yii::t('app', 'Orders'),
            'options'     => ['id' => 'tabOrders'],
            'linkOptions' => ['id' => 'tabOrdersLink'],
            'content' => $this->render('_order_index', [
                'dataProvider' => $orderDataProvider,
            ]),
            'active' => ($tab == 'tabOrdersLink'),
        ],
    ],
]);?>


<?php
    $jsBlock = <<< JS
        $('#tabCustomer a').click(function (e) {
            //5console.log('tabUpdate a clicked');
            Cookies.remove('customerTab');
            Cookies.set('customerTab', e.target.id); //,{ secure: true, domain:null } , {sameSite: 'strict'}
            // var tab = browser.cookies.set({
            //     name:'edittab',
            //     value:e.target.id,
            //     sameSite: 'lax'});
            //console.log(document.cookie)
        });
    JS;
    $this->registerJs($jsBlock, yii\web\View::POS_END);