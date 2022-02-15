<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="form-group">
    <?php $noteForm = ActiveForm::begin([
        'action' => ['workorder/update-notes', 'id' => $model->workorder_id],
        'id' => 'note-form' 
    ]) ?>
    <?= $noteForm->field($model, 'note')->label(Yii::t('app', 'Notes'))->textArea(); ?>
    <?= $noteForm->field($model, 'workorder_id')->hiddenInput(['value' => $model->workorder_id])->label(false) ?>
    <?= Html::submitButton('<span class="fa fa-upload" aria-hidden="true"></span> ' . Yii::t('app', 'Save'), [
        'class'             => 'btn btn-success',
    ])?>
    <?php $noteForm = ActiveForm::end() ?>   
</div>