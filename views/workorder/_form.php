<?php

//use Yii;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Workorder */
/* @var $form yii\widgets\ActiveForm */
if ($update) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workorders'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => \app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->firstName.' '.\app\models\Customer::find()->where(['id'=> $model->customer_id])->one()->lastName.' - '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->make.' '.\app\models\Automobile::find()->where(['id'=> $model->automobile_id])->one()->model, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
}

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
            'action' => ['update-template', 'id' => $model->id]
        ]); ?>
    <?php endif ?>
    <div class="input-group">
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
        <div class="input-group-append">
                <?= Html::button('Add Customer', [
                                'class' => 'btn btn-default btn-outline-secondary',
                                'data' => [
                                    'toggle' => 'modal',
                                    'target' => '#modalNewCustomer',
                                ],]) ?>             
        </div>
        
    </div>
    <div class="input-group">                               
        <?= $form->field($model, 'automobile_id')->label(Yii::t('app', 'Automobile'))->widget(Select2::classname(), [
                    'data' => ($update) ? \app\models\Automobile::getIds($model->customer_id) : [],
                    'options' => [
                        'id'   => 'automobile_id',
                        'placeholder' => '--'.Yii::t('app', 'Select One').'--',
                        'disabled' => !$update,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],]) ?>
        <div class="input-group-append">
                <?= Html::button('Add Automobile', [
                                'id' => 'new_automobile_button',
                                'disabled' => !$update,
                                'class' => 'btn btn-default btn-outline-secondary',
                                'data' => [
                                    'toggle' => 'modal',
                                    'target' => '#modalNewAutomobile',
                                ],]) ?>             
        </div>
    </div>
    <div class="input-group">
        <?= $form->field($model, 'odometer_reading')->label(Yii::t('app', 'Odometer Reading'))->textInput(['id' => 'odometer_reading_input','disabled' => !$update])?>
    </div>  
    <div class="form-group">
        <?= !$update ? Html::a('Cancel', 'index', ['class' => 'btn btn-default btn-outline-secondary']): '' ?>
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
                'model'=> new app\models\CustomerForm(),
                'change_form' => true,
            ]) ?>
    </div>

</div>
<?php
    yii\bootstrap\Modal::end();
?>

<?php
//------------------------
// Add new Customer
//------------------------
yii\bootstrap\Modal::begin([
    'id'    => 'modalNewAutomobile',
    'header' => Yii::t('app', 'Create New Automobile'),
    'size'  => yii\bootstrap4\Modal::SIZE_LARGE,
]);
?>

<div class="modal-body">
    <!-- Some modal content here -->
    <div id="modalContent">
        <?= Yii::$app->controller->renderPartial('/automobile/_form', [
                'model'=> new app\models\AutomobileForm(),
                'change_form' => true,
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
$('#customer_id').on('select2:select', function (e) {
    //console.log('here');
    // console.log($('#part_id').value);
    // console.log(e.params.data.id);
    updateAutomobiles();
    

});


function updateAutomobiles() {
    let selectValue = $('#customer_id').val(); 
    $('#automobile_id').empty();
    //getting automobiles
    $.ajax({
        type: 'POST',
        url: '$getAutomobilesUrl',
        data: {id: selectValue},
        success: function(data)
        {
            data = JSON.parse(data);
            for(let key in data) {
                let newOption = new Option(data[key], key);
                $('#automobile_id').append(newOption);
            }
            $('#automobile_id').attr('disabled',false);
            $('#new_automobile_button').attr('disabled',false);
            $('#odometer_reading_input').attr('disabled',false);

        },
        
        error: function( xhr, status, errorThrown ) 
        {
            console.log('Error: ' + errorThrown );
            console.log('Status: ' + status );
            console.dir( xhr );
        },
    });

}
JS;




$this->registerJs($jsBlock, \yii\web\View::POS_END);
?>
