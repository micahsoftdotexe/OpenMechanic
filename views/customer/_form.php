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
        'action' => \yii\helpers\Url::to(['/customer/initial-create']),
    ]) ?>
    <?= $customerForm->field($model, 'firstName')->label(Yii::t('app', 'First Name'))->textInput()?>
    <?= $customerForm->field($model, 'lastName')->label(Yii::t('app', 'Last Name'))->textInput()?>
    <?= $customerForm->field($model, 'phoneNumber')->label(Yii::t('app', 'Phone Number'))->widget(PhoneInput::class, [
            'id' => 'customerPhonenumber',
            //'name' => 'Customer[phone_number]',
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
    <?php $customerForm = ActiveForm::end() ?>   
</div>

<?php
if ($change_form) {
    $ajaxSubmitUrl = \yii\helpers\Url::to(['/customer/ajax-initial-create']);
    $jsBlock2 = '
        $("#initial-customer-form").on("beforeSubmit", function(){
            let data = $("#initial-customer-form").serialize();
            console.log(data);
            $.ajax({
                url:"'.$ajaxSubmitUrl.'",
                type: "POST",
                data: data,
                success: function (returnData) {
                    console.log(returnData);
                    if(returnData != 400) {
                        returnData = JSON.parse(returnData);
                        let newOption = new Option(returnData.text, returnData.id, false, false);
                        //change the forms
                        $("#customer_id").append(newOption).trigger("change");
                        $("#customer_id").val(returnData.id).trigger("change");
                        //clear form
                        $("#initial-customer-form")[0].reset();
                        $("#modalNewCustomer").modal("hide");
                        updateAutomobiles();
                        
                    } else {
                        console.log("Error")
                    }

                }, error: function( xhr, status, errorThrown ) {
                    console.log("Error: " + errorThrown );
                    console.log("Status: " + status );
                    console.dir( xhr );
                },
            })
        }).on("submit", function(e){
            e.preventDefault();
        });

    ';
    $this->registerJs($jsBlock2, \yii\web\View::POS_END);
}
?>
