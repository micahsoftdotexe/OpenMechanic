<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Workorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workorder-form">

    <?php $form = ActiveForm::begin([
        'id' => 'workorder-form'
    ]); ?>


    <?= $form->field($model, 'customer_id')->label(Yii::t('app', 'Customer'))->widget(Select2::classname(), [
                'data' => \app\models\Customer::getIds(),
                'options' => [
                    'id'   => 'customer_id',
                    'placeholder' => '--'.Yii::t('app', 'Select One').'--',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

    <?= $form->field($model, 'automobile_id')->label(Yii::t('app', 'Automobile'))->widget(Select2::classname(), [
                'data' => [],
                'options' => [
                    'id'   => 'automobile_id',
                    'placeholder' => '--'.Yii::t('app', 'Select One').'--',
                    'disabled' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
    ]) ?>
    <label class="control-label">Parts</label> <br>
    <?= yii\grid\GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getParts(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'id' => 'parts',
        'columns' => [
            'id',
            'description',
            'part_number',
            'price',
        ]
    ]) ?>

    <?= Html::button('<span class="fa fa-plus" aria-hidden="true"></span> ' . Yii::t('app', 'Add New Part'),[
            'class' => 'btn btn-default btn-outline-secondary',
            'id' => 'addNewPart',
            'data' => [
                'toggle' => 'modal',
                'target' => '#modalNewParts',
            ],
        ]) ?><br>
    
    <label class="control-label">Labor</label> 
    <?= yii\grid\GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getLabors(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'id' => 'labor',
        'columns' => [
            'id',
            'description',
            'price',
            'notes',
        ]
    ]) ?>

    <?= Html::button('<span class="fa fa-plus" aria-hidden="true"></span> ' . Yii::t('app', 'Add New Labor Instance'),[
                'class' => 'btn btn-default btn-outline-secondary',
                'id' => 'addNewLaborInstance',
                'data' => [
                    'toggle' => 'modal',
                    'target' => '#modalNewLabor',
                ],
            ]) ?>
    
    <?= $form->field($model, 'workorder_notes')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'paid_in_full')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
//------------------------
// Add new Parts
//------------------------
yii\bootstrap\Modal::begin([
    'id'    => 'modalNewParts',
    'header' => Yii::t('app', 'Create New Part'),
    'size'  => yii\bootstrap\Modal::SIZE_LARGE, 
    //'toggleButton' => [  // Disabled, so we can call modal from another custom button
    //    'id'    => 'modalButtonUploadFiles',
    //    'label' => '<i class="fa fa-upload" aria-hidden="true"></i> ' . Yii::t('app', 'Upload'), 
    //    'class' => 'btn btn-default btn-outline-secondary',
    //],
]);
?>

<div class="modal-body">
    <!-- Some modal content here -->
    <div id="modalContent"></div>

    <?= Yii::$app->controller->renderPartial('/part/_form', [
        'model'               => new app\models\Part(),
        // 'presentation'        => $model,
        // 'dataProvider'        => $dataProvider,
        // 'next'                => true,
        // 'show_partial' => false,
    ]) ?>

</div>

<?php
    yii\bootstrap\Modal::end();
?>

<?php
//------------------------
// Add new Labor
//------------------------
yii\bootstrap\Modal::begin([
    'id'    => 'modalNewLabor',
    'header' => Yii::t('app', 'Create New Labor Instance'),
    'size'  => yii\bootstrap\Modal::SIZE_LARGE, 
    //'toggleButton' => [  // Disabled, so we can call modal from another custom button
    //    'id'    => 'modalButtonUploadFiles',
    //    'label' => '<i class="fa fa-upload" aria-hidden="true"></i> ' . Yii::t('app', 'Upload'), 
    //    'class' => 'btn btn-default btn-outline-secondary',
    //],
    'footer' => "<div id='nextStageFooter'>
    <a id=\"newPart\" class=\"btn btn-success\" aria-hidden=\"true\" href='#' onclick =\"if (confirm('Are you really ready to create the labor instance?')) {
        createNewLabor();
    } else {
        $('#modalNewLabor').modal('hide');
    }
    \" >Send</a>
        <a id='closeLabor' class='btn btn-default btn-outline-secondary' onclick='$(\"#modalNewLabor\").modal(\"hide\");'$>Close</a> 
    </div>"
]);
?>
<div class="modal-body">
    <!-- Some modal content here -->
    <div id="modalContent"></div>

    <?= Yii::$app->controller->renderPartial('/labor/_form', [
        'model'               => new app\models\Labor(),
        // 'presentation'        => $model,
        // 'dataProvider'        => $dataProvider,
        // 'next'                => true,
        // 'show_partial' => false,
    ]) ?>

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
var partForm = $('#part-form');
partForm.on('beforeSubmit', function() {
    var data = partForm.serialize();
    console.log(data);
    $.ajax({
        url: '$submitPartFormUrl',
        type: 'POST',
        data: data,
        success: function (data) {
            console.log(data);
        },
        error: function( xhr, status, errorThrown ) 
        {
            console.log('Error: ' + errorThrown );
            console.log('Status: ' + status );
            console.dir( xhr );
        },
    });
    return false;
});


JS;




$this->registerJs($jsBlock, \yii\web\View::POS_END);
?>
