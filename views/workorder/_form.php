<?php

//use Yii;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Workorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workorder-form">
    <?php if (!$update) : ?>
        <?php $form = ActiveForm::begin([
            'id' => 'workorder-form',
            'action' => 'create-template'
        ]); ?>   
    <?php else : ?>
        <?php $form = ActiveForm::begin([
            'id' => 'workorder-form',
            'action' => 'update-template'
        ]); ?>
    <?php endif ?>
    <div class="input-group">
        <div class="input-group-prepend">
                <?= Html::button('Hello', [
                                'class' => 'btn btn-default btn-outline-secondary',
                                'data' => [
                                    'toggle' => 'modal',
                                    'target' => '#modalNewCustomer',
                                ],]) ?>             
        </div>
        <?= $form->field($model, 'customer_id')->label(Yii::t('app', 'Customer'))->widget(Select2::class, [
                    'data' => \app\models\Customer::getIds(),
                    'options' => [
                        'id'   => 'customer_id',
                        'placeholder' => '--'.Yii::t('app', 'Select One').'--',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
        
    </div>

    <?= $form->field($model, 'automobile_id')->label(Yii::t('app', 'Automobile'))->widget(Select2::classname(), [
                'data' => [],
                'options' => [
                    'id'   => 'automobile_id',
                    'placeholder' => '--'.Yii::t('app', 'Select One').'--',
                    'disabled' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],]) ?>

    <div class="form-group">
        <?= Html::a('Cancel', '/index', ['class' => 'btn btn-default btn-outline-secondary']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-success']) ?>
    </div>

   

    <?php ActiveForm::end(); ?>
</div>

<?php
//------------------------
// Add new Customer
//------------------------
yii\bootstrap\Modal::begin([
    'id'    => 'modalNewCustomer',
    'header' => Yii::t('app', 'Create New Customer'),
    'size'  => yii\bootstrap4\Modal::SIZE_LARGE,
]);
?>

<div class="modal-body">
    <!-- Some modal content here -->
    <div id="modalContent">
        <?= Yii::$app->controller->renderPartial('/customer/_form', [
                'model'=> new app\models\Customer(),
            ]) ?>
    </div>

</div>
<?php
    yii\bootstrap\Modal::end();
?>


<?php
//------------------------------------------------------------------------------
// Variables
//------------------------------------------------------------------------------
$getAutomobilesUrl = \yii\helpers\Url::to(['/workorder/get-automobiles']);
$submitPartFormUrl = \yii\helpers\Url::to(['/part/submit-part-form-url']);
//------------------------------------------------------------------------------
// Javascript
//------------------------------------------------------------------------------
$jsBlock = <<< JS


// Populate Automobiles
$('#customer_id').on('select2:change', function (e) {
    console.log($('#part_id').value);
    console.log(e.params.data.id);
    var selectValue = $('#customer_id').val(); 
    $('#automobile_id').empty();
    //getting automobiles
    $.ajax({
        type: 'POST',
        url: '$getAutomobilesUrl',
        data: {id: selectValue},
        success: function(data)
        {
            console.log(data);
            data = JSON.parse(data);
            //console.log(data[0]);
            data.forEach(function(item) {
                var newOption = new Option(item.text, item.id, true, true);
                $('#automobile_id').append(newOption);
            });
            $('#automobile_id').attr('disabled',false);

        },
        
        error: function( xhr, status, errorThrown ) 
        {
            console.log('Error: ' + errorThrown );
            console.log('Status: ' + status );
            console.dir( xhr );
        },
    });

});
// Part Form
// var partForm = $('#part-form');
// partForm.on('beforeSubmit', function() {
//     var data = partForm.serialize();
//     console.log(data);
//     $.ajax({
//         url: '$submitPartFormUrl',
//         type: 'POST',
//         data: data,
//         success: function (data) {
//             console.log(data);
//         },
//         error: function( xhr, status, errorThrown ) 
//         {
//             console.log('Error: ' + errorThrown );
//             console.log('Status: ' + status );
//             console.dir( xhr );
//         },
//     });
//     return false;
// });


JS;




$this->registerJs($jsBlock, \yii\web\View::POS_END);
?>
