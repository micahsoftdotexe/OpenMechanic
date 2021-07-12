<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="media-file-form">
    <?php $partForm = ActiveForm::begin() ?>
    <?= $partForm->field($model,'description')->label(Yii::t('app','Part Description'))->textInput() ?>
    <?= $partForm->field($model,'part_number')->label(Yii::t('app','Part Number'))->textInput() ?>
    <?= $partForm->field($model,'margin')->label(Yii::t('app','Part Price Margin'))->textInput(['type'=>'number']) ?>
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
    <?php $partForm = ActiveForm::end() ?>
</div>