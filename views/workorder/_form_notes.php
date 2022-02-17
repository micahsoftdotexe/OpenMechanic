<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<br/>
<div id="notes" class="container">
    <?php foreach ($workorder->notes as $note): ?>
        <?php $noteEditForm = ActiveForm::begin(['action' => ['/note/update', 'id' => $note->id]]); ?>
            <?= '<div id="note-'.$note->id.'" class="row">' ?>
                <div class="col-md-2">
                    <?= $noteEditForm->field($note, 'text')->label(false)->textArea(['disabled' => true, 'id' => 'text-'.$note->id]); ?>
                    <?= $noteEditForm->field($note, 'workorder_id')->hiddenInput(['value' => $workorder->id])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>',
                        '#',
                        [
                            'onclick' => 'editNote('.$note->id.')',
                            'data' => [
                            'method' => 'post',
                            ],
                            'class' => 'edit-btn',
                        ]); ?>
                    <?= Html::a('<i class="glyphicon glyphicon-trash"></i>',
                            ['/note/delete', 'id' => $note->id],
                            [
                                'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                                ]
                            ]
                        );
                    ?> 
                </div>
                
            </div>
            <?= Html::submitButton(Yii::t('app', 'Update'), [
                    'class' => 'btn btn-success invisible',
                    'id' => 'save-'.$note->id,
                ])?>
        <?php $noteEditForm = ActiveForm::end();?>
    <?php endforeach; ?>
        
</div>

<div class="form-group">
    <?php $model = new \app\models\Note(); ?>
    <?php $noteForm = ActiveForm::begin([
        'action' => ['/note/create'],
        'id' => 'note-form'
    ]) ?>
    <?= $noteForm->field($model, 'text')->label(Yii::t('app', 'New Note'))->textArea(['rows'=>5]); ?>
    <?= $noteForm->field($model, 'workorder_id')->hiddenInput(['value' => $workorder->id])->label(false) ?>
    <?= Html::submitButton('<span class="fa fa-upload" aria-hidden="true"></span> ' . Yii::t('app', 'Save'), [
        'class'             => 'btn btn-success',
    ])?>
    <?php $noteForm = ActiveForm::end() ?>   
</div>

<?php
$jsBlock = <<< JS
    function editNote(id) {
        $('#text-'+id).prop('disabled', false);
        $('#save-'+id).removeClass('invisible');
        return false;
        //$('#note-'+id).addClass('note-edit');
    }
    $("a.edit-btn").click(function(e) {
        return false;
    });
JS;
$this->registerJs($jsBlock, \yii\web\View::POS_END);