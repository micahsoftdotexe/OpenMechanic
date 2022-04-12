<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php
$this->title = Yii::t('app', 'Update Order: {name}', [
    'name' => \app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->first_name.' '.\app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->last_name.' - '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->make.' '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->model,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => \app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->first_name.' '.\app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->last_name.' - '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->make.' '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->model, 'url' => ['edit', 'id' => $model->id]];
$finalizeTabCheck = ($tab == 'tabFinalizeLink') && ((\app\models\Order::$stages[$model->stage] == 'Completed') || (\app\models\Order::$stages[$model->stage] == 'Paid'));
$finalizeCheck = ((\app\models\Order::$stages[$model->stage] == 'Completed') || (\app\models\Order::$stages[$model->stage] == 'Paid'));

?>
<h1><?= Html::encode($this->title) ?></h1>
<h3><?= Yii::t('app', 'Stage: "'.$model->stageName.'"' ) ?></h3>
<?= Yii::$app->user->can('changeStage', ['id' => $model->id, 'increment' => -1]) ? Html::a('<span class="glyphicon glyphicon-arrow-left"></span> '.Yii::t('app', 'Previous'), Url::to(['/order/change-stage', 'id' => $model->id, 'increment' => -1]), ['class' => 'btn']):'' ?>
<?= Yii::$app->user->can('changeStage', ['id' => $model->id, 'increment' => 1]) ? Html::a('<span class="glyphicon glyphicon-arrow-right"></span> '.Yii::t('app', 'Next'), Url::to(['/order/change-stage', 'id' => $model->id, 'increment' => 1]), ['class' => 'btn']):'' ?>
<?php if ($finalizeCheck) : ?>
    <?=  \yii\bootstrap\Tabs::widget([
        'options' => ['id' => 'tabUpdate'],
        'items'   => [
            [
                'label'       => Yii::t('app', 'Customer and Automobile'),
                'options'     => ['id' => 'tabCustomerAutomobile'],
                'linkOptions' => ['id' => 'tabCustomerAutomobileLink'],
                'active'      => $tab == 'tabCustomerAutomobileLink',
                'content' => $this->render('_form', [
                    'model'  => $model,
                    'update' => true
                ])
            ],
            [
                'label'       => Yii::t('app', 'Parts and Labor'),
                'options'     => ['id' => 'tabPartsLabor'],
                'linkOptions' => ['id' => 'tabPartsLaborLink'],
                'active'      => $tab == 'tabPartsLaborLink',
                'content'     => $this->render('_form_parts_labor', [
                    'model'             => $model,
                    'update'            => true,
                    'partDataProvider'  => $partDataProvider,
                    'laborDataProvider' => $laborDataProvider,
                ])
            ],
            [
                'label'       => Yii::t('app', 'Notes'),
                'options'     => ['id' => 'tabNotes'],
                'linkOptions' => ['id' => 'tabNotesLink'],
                'active'      => $tab == 'tabNotesLink',
                'content'     => $this->render('_form_notes', [
                    'order'  => $model,
                    'update' => true,
                ])
            ],
            [
                'label'       => Yii::t('app', 'Finalize'),
                'options'     => ['id' => 'tabFinalize'],
                'linkOptions' => ['id' => 'tabFinalizeLink'],
                'active'      => $finalizeTabCheck,
                'content'     => $this->render('_form_finalize', [
                    'order' => $model,
                ])
            ],
        ],
    ]); ?>
<?php else : ?>
    <?=  \yii\bootstrap\Tabs::widget([
        'options' => ['id' => 'tabUpdate'],
        'items'   => [
            [
                'label'       => Yii::t('app', 'Customer and Automobile'),
                'options'     => ['id' => 'tabCustomerAutomobile'],
                'linkOptions' => ['id' => 'tabCustomerAutomobileLink'],
                'active'      => $tab == 'tabCustomerAutomobileLink' || $tab == 'tabFinalizeLink',
                // 'content' => $this->render('update', [
                //     'model' => $model,
                // ])
                'content' => $this->render('_form', [
                    'model'  => $model,
                    'update' => true
                ])
            ],
            [
                'label'       => Yii::t('app', 'Parts and Labor'),
                'options'     => ['id' => 'tabPartsLabor'],
                'linkOptions' => ['id' => 'tabPartsLaborLink'],
                'active'      => $tab == 'tabPartsLaborLink',
                'content'     => $this->render('_form_parts_labor', [
                    'model'             => $model,
                    'update'            => true,
                    'partDataProvider'  => $partDataProvider,
                    'laborDataProvider' => $laborDataProvider,
                ])
            ],
            [
                'label'       => Yii::t('app', 'Notes'),
                'options'     => ['id' => 'tabNotes'],
                'linkOptions' => ['id' => 'tabNotesLink'],
                'active'      => $tab == 'tabNotesLink',
                'content'     => $this->render('_form_notes', [
                    'order'  => $model,
                    'update' => true,
                ])
            ],
        ],
    ]); ?>
<?php endif; ?>


<?php
    $jsBlock = <<< JS
        $('#tabUpdate a').click(function (e) {
            console.log('tabUpdate a clicked');
            Cookies.remove('edittab');
            Cookies.set('edittab', e.target.id); //,{ secure: true, domain:null } , {sameSite: 'strict'}
            // var tab = browser.cookies.set({
            //     name:'edittab',
            //     value:e.target.id,
            //     sameSite: 'lax'});
            //console.log(document.cookie)
        });
    JS;
    $this->registerJs($jsBlock, yii\web\View::POS_END);