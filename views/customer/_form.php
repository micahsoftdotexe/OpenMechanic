<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">
    <?php $customerForm = ActiveForm::begin([
        'id' => 'initial-customer-form',
        'action' => \yii\helpers\Url::to(['/customer/ajax-create']),
    ]) ?>
    <?= $customerForm->field($model, 'firstName')->label(Yii::t('app', 'First Name'))->textInput()?>
    <?= $customerForm->field($model, 'lastName')->label(Yii::t('app', 'Last Name'))->textInput()?>
    <?= $customerForm->field($model, 'phoneNumber')->label(Yii::t('app', 'Phone Number'))->widget(PhoneInput::class, [
            'id' => 'customerPhonenumber',
            'name' => 'Customer[phone_number]',
            'jsOptions' => [
                'allowExtensions' => true,
            ]
        ])?>
    <?= $customerForm->field($model, 'streetAddress')->label(Yii::t('app', 'Street Police'))->textInput()?>
    <?= $customerForm->field($model, 'city')->label(Yii::t('app', 'City'))->textInput()?>
    <?= $customerForm->field($model, 'state')->label(Yii::t('app', 'State'))->textInput()?>
    <?= $customerForm->field($model, 'zip')->label(Yii::t('app', 'Zip'))->textInput()?>
    <?= Html::submitButton('<span class="fa fa-upload" aria-hidden="true"></span> ' . Yii::t('app', 'Upload'), [
        'class'             => 'btn btn-success',
    ])?>
    <?php $partForm = ActiveForm::end() ?>
    

    

</div>

<?php
$newCustomerUrl = \yii\helpers\Url::to(['/customer/ajax-create']);
$jsBlock = <<< JS
    $('#customerForm').submit(function(e){
        e.preventDefault();
        console.log(e.target.querySelector('#customerFirstName').value);
        console.log(e.target.querySelector('#customerLastName').value);
        console.log( e.target.querySelector('#customerPhonenumber').value);
        $.ajax({
            url: '$newCustomerUrl',
            method: 'POST',
            data: {
                firstName: e.target.querySelector('#customerFirstName').value,
                lastName: e.target.querySelector('#customerLastName').value,
                phoneNumber: e.target.querySelector('#customerPhonenumber').value
            },
            error: function( xhr, status, errorThrown)
            {
                console.dir( xhr );
            }

        })
    })
JS;
$this->registerJs($jsBlock, \yii\web\View::POS_END);
?>
