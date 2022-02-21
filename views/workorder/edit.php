<?php

use app\models\Workorder;
use yii\helpers\Html;

//webtoucher\cookie\AssetBundle::register($this);
?>

<?php
$this->title = Yii::t('app', 'Update Workorder: {name}', [
    'name' => \app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->first_name.' '.\app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->last_name.' - '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->make.' '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->model,
]);
?>
 <h1><?= Html::encode($this->title) ?></h1>
<?= \yii\bootstrap\Tabs::widget([
    'options' => ['id' => 'tabUpdate'],
    'items' => [
        [
            'label' => Yii::t('app', 'Customer and Automobile'),
            'options' => ['id' => 'tabCustomerAutomobile'],
            'linkOptions' => ['id' => 'tabCustomerAutomobileLink'],
            'active' => $tab == 'tabCustomerAutomobileLink',
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
            'options' => ['id' => 'tabPartsLabor'],
            'linkOptions' => ['id' => 'tabPartsLaborLink'],
            'active' => $tab == 'tabPartsLaborLink',
            'content' => $this->render('_form_parts_labor', [
                'model' => $model,
                'update' => true,
                'partDataProvider' => $partDataProvider,
                'laborDataProvider' => $laborDataProvider,
            ])
        ],
        [
            'label' => Yii::t('app', 'Notes'),
            'options' => ['id' => 'tabNotes'],
            'linkOptions' => ['id' => 'tabNotesLink'],
            'active' => $tab == 'tabNotesLink',
            'content' => $this->render('_form_notes', [
                //'model' => $model->notesForm,
                'workorder' => $model,
                'update' => true,
                //'partDataProvider' => $partDataProvider,
                //'laborDataProvider' => $laborDataProvider,
            ])
        ],
    ],
]); ?>

<?php
    $jsBlock = <<< JS
        $('#tabUpdate a').click(function (e) {
            console.log('tabUpdate a clicked');
            Cookies.set('edittab', e.target.id);
        });
    JS;
    $this->registerJs($jsBlock, yii\web\View::POS_END);