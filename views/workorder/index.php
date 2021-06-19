<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WorkorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Workorders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workorder-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Workorder'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'label' => 'Full Name',
                'attribute' => 'customer_id',
                'value' => function($model) {
                    $name = app\models\Customer::find()->where(['id' => $model->customer_id])->one();
                    return $name->fullName;
                }
            ],
            // 'customer.fullName',
            // 'customer_id',
            'automobile_id',
            'date',
            'subtotal',
            //'tax',
            //'workorder_notes:ntext',
            //'amount_paid',
            //'paid_in_full',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
