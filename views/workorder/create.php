<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Workorder */

$this->title = Yii::t('app', 'Create Workorder');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workorders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workorder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
