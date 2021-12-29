<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\money\MaskMoney;

?>

<div class="media-file-form">
    <?php $partForm = ActiveForm::begin([
        'id' => 'part-form'
    ]) ?>
    <?= $partForm->field($model,'description')->label(Yii::t('app','Part Description'))->textInput() ?>
    <?= $partForm->field($model,'part_number')->label(Yii::t('app','Part Number'))->textInput() ?>
    <?= $partForm->field($model,'price')->label(Yii::t('app','Price'))->widget(MaskMoney::className(), [
        'pluginOptions' => [
            'prefix' => '$ ',
            'allowNegative' => false,
            'precision' => 2,

        ]
    ]) ?>
    <?= $partForm->field($model,'margin')->label(Yii::t('app','Part Price Margin'))->textInput([
        'type'=>'number',
        'step' =>'0.001',]) ?>
    <?= $partForm->field($model, 'quantity')->label(Yii::t('app','Quantity')) ?>
    <?= $partForm->field($model, 'quantity_type_id')->label(Yii::t('app', 'Quantity Type'))->widget(Select2::classname(), [
                'data' => \app\models\QuantityType::getIds(),
                'options' => [
                    'id'   => 'quantity_id',
                    'placeholder' => '--'.Yii::t('app', 'Select One').'--',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
    <?= Html::submitButton('<span class="fa fa-upload" aria-hidden="true"></span> ' . Yii::t('app', 'Upload'), [
            'class'             => 'btn btn-success',
            'id'                => "btn-upload-file",
            'data-loading-text' => Yii::t('app', "Loading..."),
        ]) ?>
    <?= Html::a('Close', '#', [
        'onclick' => '$(\"#modalNewParts\").modal(\"hide\")',
        'class' => 'btn btn-default btn-outline-secondary',
    ]); ?>
    <?php $partForm = ActiveForm::end() ?>
</div>