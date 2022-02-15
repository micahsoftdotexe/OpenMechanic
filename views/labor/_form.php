<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\money\MaskMoney;

?>

<div class="form">
    <?php $laborForm = ActiveForm::begin([
        'action' => $edit ? ['labor/update', 'id' => $model->id]: ['/labor/create-edit'],
        'id' => 'labor-form'
    ]) ?>
    <?= $laborForm->field($model, 'description')->label(Yii::t('app', 'Labor Description'))->textInput() ?>
    <?= $laborForm->field($model, 'price')->label(Yii::t('app', 'Price'))->widget(MaskMoney::class, [
        'pluginOptions' => [
            'prefix' => '$ ',
            'allowNegative' => false,
            'precision' => 2,

        ]
    ]) ?>
    <?= $laborForm->field($model, 'notes')->label(Yii::t('app', 'Notes'))->textarea() ?>
    <?= $laborForm->field($model, 'workorder_id')->hiddenInput(['value' => $workorder_id])->label(false) ?>
    <?= Html::submitButton('<span class="fa fa-upload" aria-hidden="true"></span> ' . Yii::t('app', 'Create'), [
            'class'             => 'btn btn-success',
            'id'                => "btn-save-labor",
            'data-loading-text' => Yii::t('app', "Loading..."),
        ]) ?>
    <?= Html::a('Close', $edit ? ['/workorder/edit', 'id' => $model->workorder_id]:'#', [
        'onclick' => !$edit?'$("#modalNewPart").modal("hide")':'',
        'class' => 'btn btn-default btn-outline-secondary',
    ]); ?>
    <?php $partForm = ActiveForm::end() ?>
</div>