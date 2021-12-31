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
    <?= $automobileForm->field($model, 'motor_number')->label(Yii::t('app', 'Motor Number'))->textInput()?>
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
    if ($change_form) {
        $ajaxSubmitUrl = \yii\helpers\Url::to(['/automobile/ajax-initial-create']);
        $jsBlock2 = '
            $("#initial-automobile-form").on("beforeSubmit", function(){
                let data = $("#initial-automobile-form").serialize();
                console.log(data);
                $.ajax({
                    url:"'.$ajaxSubmitUrl.'",
                    type: "POST",
                    data: data,
                    success: function (returnData) {
                        //console.log(returnData);
                        if(returnData != 400) {
                            returnData = JSON.parse(returnData);
                            let newOption = new Option(returnData.text, returnData.id, false, false);
                            //change the forms
                            $("#automobile_id").append(newOption).trigger("change");
                            $("#automobile_id").val(returnData.id).trigger("change");
                            //clear form
                            $("#initial-automobile-form")[0].reset();
                            $("#modalNewAutomobile").modal("hide");
                        } else {
                            console.log("error");
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