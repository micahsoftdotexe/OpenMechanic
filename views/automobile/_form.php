<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="automobile-form">
    <?php $automobileForm = ActiveForm::begin([
        'id' => 'initial-automobile-form',
        'action' => \yii\helpers\Url::to(['/automobile/initial-create']),
    ]) ?>
    <?= $automobileForm->field($model, 'make')->label(Yii::t('app', 'Make'))->textInput()?>
    <?= $automobileForm->field($model, 'model')->label(Yii::t('app', 'Model'))->textInput()?>
    <?= $automobileForm->field($model, 'year')->label(Yii::t('app', 'Year'))->textInput()?>
    <?= $automobileForm->field($model, 'vin')->label(Yii::t('app', 'VIN'))->textInput()?>
    <?= $automobileForm->field($model, 'customer_id')->hiddenInput(['id' => 'customer_id_field'])->label(false)?>
    <?= Html::submitButton('<span class="fa fa-upload" aria-hidden="true"></span> ' . Yii::t('app', 'Upload'), [
        'class'             => 'btn btn-success',
    ])?>
    <?php $automobileForm = ActiveForm::end() ?>   
</div>

<?php
    $jsBlock = <<< JS
    $('#modalNewAutomobile').on('shown.bs.modal', function () {
        document.getElementById('customer_id_field').value = $('#customer_id').val();
    })
    JS;
    $this->registerJs($jsBlock, \yii\web\View::POS_END);
?>