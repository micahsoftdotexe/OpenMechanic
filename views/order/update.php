<?php
//DO NOT USE THIS ONE
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="order-update">

    <?= $this->render('_form', [
        'model' => $model,
        'update' => true
    ]) ?>

</div>
