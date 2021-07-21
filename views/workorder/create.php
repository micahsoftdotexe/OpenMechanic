<?php

use app\models\Workorder;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Workorder */

$this->title = Yii::t('app', 'Create Workorder');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workorders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workorder-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($model->scenario == Workorder::SCENARIO_STEP1): ?>
        <?= $this->render('_form_stage1', [
            'model' => $model,
        ]) ?>
    <?php elseif($model->scenario ==  Workorder::SCENARIO_STEP2): ?>
        <?= $this->render('_form_stage2', [
            'model' => $model,
        ]) ?>
    <?php elseif($model->scenario ==  Workorder::SCENARIO_STEP3): ?>
        <?= $this->render('_form_stage3', [
            'model' => $model,
        ]) ?>
    <?php endif; ?>
    

</div>
