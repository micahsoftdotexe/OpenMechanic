<?php
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>

<div class="workorder-form">
    <?php Pjax::begin(['id' => 'parts']) ?>
        <?= GridView::widget([
            'dataProvider' => $model->parts,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'description',
                'part_number',
                'price',
            ]
        ]) ?>
    <?php Pjax::end() ?>
    <?= Html::button('<span class="fa fa-plus" aria-hidden="true"></span> ' . Yii::t('app', 'Add New Part'),[
            'class' => 'btn btn-default btn-outline-secondary',
            'id' => 'addNewPart',
            'data' => [
                'toggle' => 'modal',
                'target' => '#modalNewParts',
            ],
        ]) ?><br>
       
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
$jsBlock = <<< JS
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
            $.pjax.reload({container:"#parts"});
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