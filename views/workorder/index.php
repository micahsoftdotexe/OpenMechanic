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
        <?= Html::a(Yii::t('app', 'Create Work Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'fullName',
            // [
            //     'label' => 'Full Name',
            //     'attribute' => 'fullName',
            //     'value' => function($model) {
            //         // $name = app\models\Customer::find()->where(['id' => $model->customer_id])->one();
            //         // return $name->fullName;
            //         return $model->getFullName();
            //     }
            // ],
            // 'customer.fullName',
            // 'customer_id',
            // 'automobile_id',
            [
                'label' => 'Make',
                'attribute' => 'make',
                'value' => function($model) {
                    $automobile = app\models\Automobile::find()->where(['id' => $model->automobile_id])->one();
                    return $automobile->make;
                }
            ],
            [
                'label' => 'Model',
                'attribute' => 'model',
                'value' => function($model) {
                    $automobile = app\models\Automobile::find()->where(['id' => $model->automobile_id])->one();
                    return $automobile->model;
                }
            ],
            'date',
            //'subtotal',
            //'tax',
            //'workorder_notes:ntext',
            //'amount_paid',
            //'paid_in_full',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{edit}{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], [
                                'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },
                    'edit' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'lead-update'),
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'lead-delete'),
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>


</div>
