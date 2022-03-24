<?php
use yii\helpers\Html;

$createPart  = Yii::$app->user->can('createPart');
$createLabor = Yii::$app->user->can('createLabor');
?>
<h1> Parts and Labor </h1>
<div id="partsdiv">
    <h2>Parts</h2>
    <?= yii\grid\GridView::widget([
        'id' => 'partGrid',
        'dataProvider' => $partDataProvider,
        'columns' => [
            'part_number',
            'description',
            'price',
            'quantity',
            [
                'label' => 'Quantity Type',
                'attribute' => 'quantity_type_id',
                'value'=> function($model) {
                    return \app\models\QuantityType::findOne(['id' => $model->quantity_type_id ])->description;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update'=> function ($url, $model, $key) {
                        return Yii::$app->user->can('editPart') ? Html::a('<i class="glyphicon glyphicon-pencil"></i>',
                        ['/part/update', 'id' => $model->id],
                        [
                            'data' => [
                            'method' => 'post',
                            ]
                        ]) : '';
                    },
                    'delete'=> function ($url, $model, $key) {
                        return Yii::$app->user->can('deletePart') ? Html::a('<i class="glyphicon glyphicon-trash"></i>',
                        ['/part/delete-edit', 'id' => $model->id],
                        [
                            'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                            ]
                        ]): '';
                    }
                ]
            ]
        ]
    ])?>
    <?= Html::button('Add Part', [
        'id' => 'new_part_button',
        'disabled' => !$update || !$createPart,
        'class' => 'btn btn-default btn-outline-secondary',
        'data' => [
            'toggle' => 'modal',
            'target' => '#modalNewPart',
        ],]) ?>   
</div>
<div id="labordiv">
    <h2>Labor</h2>
    <?= yii\grid\GridView::widget([
        'id' => 'laborGrid',
        'dataProvider' => $laborDataProvider,
        'columns' => [
            'description',
            'price',
            'notes',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update'=> function ($url, $model, $key) {
                        return Yii::$app->user->can('editLabor') ? Html::a('<i class="glyphicon glyphicon-pencil"></i>',
                        ['/labor/update', 'id' => $model->id],
                        [
                            'data' => [
                            'method' => 'post',
                            ]
                        ]): '';
                    },
                    'delete'=> function ($url, $model, $key) {
                        return Yii::$app->user->can('deleteLabor') ? Html::a('<i class="glyphicon glyphicon-trash"></i>',
                        ['/labor/delete-edit', 'id' => $model->id],
                        [
                            'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                            ]
                        ]) : '';
                    }
                ]
            ]
        ]
        ])?>
    <?= Html::button('Add Labor Instance', [
        'id' => 'new_labor_button',
        'disabled' => !$update || !$createLabor,
        'class' => 'btn btn-default btn-outline-secondary',
        'data' => [
            'toggle' => 'modal',
            'target' => '#modalNewLabor',
        ],]) ?>
</div>

<?php
//------------------------
// Add new Part
//------------------------
yii\bootstrap\Modal::begin([
    'id'    => 'modalNewPart',
    'header' => Yii::t('app', 'Create New Part'),
    'size'  => yii\bootstrap4\Modal::SIZE_LARGE,
]);
?>

<div class="modal-body">
    <!-- Some modal content here -->
    <div id="modalContent">
        <?= Yii::$app->controller->renderPartial('/part/_form', [
                'model'=> new app\models\Part(),
                'edit' => false,
                'order_id' => $model->id,
            ]) ?>
    </div>

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
    'size'  => yii\bootstrap4\Modal::SIZE_LARGE,
]);
?>

<div class="modal-body">
    <!-- Some modal content here -->
    <div id="modalContent">
        <?= Yii::$app->controller->renderPartial('/labor/_form', [
                'model'=> new app\models\Labor(),
                'edit' => false,
                'order_id' => $model->id,
            ]) ?>
    </div>

</div>
<?php
    yii\bootstrap\Modal::end();
?>
<?php
    $jsBlock = <<< JS
        // $('#part-form').on("beforeSubmit",function(event){
        //     console.log("beforeSubmit");
        //     event.preventDefault();
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'post',
        //         dataType: 'json',
        //         data: $(this).serializeArray(),
        //         success: function (returnData) {
        //             addPartToGrid(returnData.data);

        //         }, error: function( xhr, status, errorThrown ) {
        //             console.log("Error: " + errorThrown );
        //             console.log("Status: " + status );
        //             console.dir( xhr );
        //         },
        //     })
        //     return false;
        // })

        // function addPartToGrid(data)
        // {
        //     console.log("addPartToGrid");
        // //     var grid = $('#partGrid').data('kendoGrid');
        // //     grid.dataSource.add(data);
        // //     grid.refresh();
        // //     $('#modalNewPart').modal('hide');
        // }
    JS;
    $this->registerJs($jsBlock, \yii\web\View::POS_END);
