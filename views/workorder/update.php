<?php
//DO NOT USE THIS ONE
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Workorder */


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workorders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="workorder-update">

    <?= $this->render('_form', [
        'model' => $model,
        'update' => true
    ]) ?>

</div>
