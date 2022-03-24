<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\money\MaskMoney;

?>

<div class="form-group">
    <?php $partForm = ActiveForm::begin([
        'action' => $edit ? ['part/update', 'id' => $model->id]: ['/part/create-edit'],
        'id' => 'part-form'
    ]) ?>
    <?= $partForm->field($model, 'description')->label(Yii::t('app', 'Part Description'))->textInput() ?>
    <?= $partForm->field($model, 'part_number')->label(Yii::t('app', 'Part Number'))->textInput() ?>
    <?= $partForm->field($model, 'price')->label(Yii::t('app', 'Price'))->widget(MaskMoney::class, [
        'pluginOptions' => [
            'prefix' => '$ ',
            'allowNegative' => false,
            'precision' => 2,

        ]
    ]) ?>
    <?= $partForm->field($model, 'margin', [
        'template' => '{label}<div style="width:15%"class="input-group">{input}<span class="input-group-addon">%</span></div>',
    ])->label(Yii::t('app', 'Part Price Margin'))->textInput([
        'type'=>'number',
        'step'=> 1,
        'min'=> 0,
        'max'=> 100,
        //'style' => 'width:8%'
        ]) ?>
    <?= $partForm->field($model, 'quantity')->textInput([
        'type'=>'number',
        'min'=>0,
        //'max'=> 100,
        'step'=>1,
        ]) ?>
    <?= $partForm->field($model, 'quantity_type_id')->label(Yii::t('app', 'Quantity Type'))->widget(Select2::class, [
                'data' => \app\models\QuantityType::getIds(),
                'options' => [
                    'id'   => 'quantity_id',
                    'placeholder' => '--'.Yii::t('app', 'Select One').'--',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
    <?= $partForm->field($model, 'order_id')->hiddenInput(['value' => $order_id])->label(false) ?>
    <?= Html::submitButton('<span class="fa fa-upload" aria-hidden="true"></span> ' . Yii::t('app', 'Create'), [
            'class'             => 'btn btn-success',
            'id'                => "btn-save-part",
            'data-loading-text' => Yii::t('app', "Loading..."),
        ]) ?>
    <?= Html::a('Close', $edit?['/order/edit', 'id' => $order_id]:'#', [
        'onclick' => !$edit ?'$("#modalNewPart").modal("hide")':'',
        'class' => 'btn btn-default btn-outline-secondary',
    ]); ?>
    <?php $partForm = ActiveForm::end() ?>
</div>
