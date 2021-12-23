<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    
    <form id="customerForm">
        <div class="form-group">
            <label for="customerFirstName">First Name</label>
            <?= Html::input('text', 'Customer[firstname]', null, ['class' => 'form-control', 'id' => 'customerFirstName', 'required' => true]) ?>
        </div>
        <div class="form-group">
            <label for="customerLastName">Last Name</label>
            <?= Html::input('text', 'Customer[lastname]', null, ['class' => 'form-control', 'id' => 'customerLastName', 'required' => true]) ?>
        </div>
        <div class="form-group">
            <label for="customerPhonenumber">Phone Number</label>
            <?= PhoneInput::widget([
                'id' => 'customerPhonenumber',
                'name' => 'Customer[phone_number]',
                'jsOptions' => [
                    'allowExtensions' => true,
                ]
            ]); ?>
        </div>

        <div class="form-group">
            <input class = "btn btn-success" id="customerFormSend" type="submit" name="Send" value="Send"></input>
        </div>
    </form>

    

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
