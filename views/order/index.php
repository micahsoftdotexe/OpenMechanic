<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if (Yii::$app->user->can('createOrder')) {
                echo Html::a(Yii::t('app', 'Create Work Order'), ['create'], ['id' => 'order-create','class' => 'btn btn-success']);

            }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'fullName',
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
            [
                //'label' => 'Date',
                'attribute' => 'date',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class'=>'form-control'
                    ],
                ]),
                'format' => 'html',
            ],
            [
                'attribute' => 'subtotal',
                'value' => function($model) {
                    return '$' . $model->subtotal;
                }
            ],
            [
                'attribute' => 'stage',
                'value' => function($model) {
                    return \app\models\Order::$stages[$model->stage];
                },
                'filter' => \app\models\Order::$stages,
            ],
            //'tax',
            //'order_notes:ntext',
            //'amount_paid',
            //'paid_in_full',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], [
                                'title' => Yii::t('app', 'view order'),
                        ]);
                    },
                    'edit' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'edit order'),
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        if (Yii::$app->user->can('deleteOrder')) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                                'title' => Yii::t('app', 'delete order'),
                            ]);
                        }
                        else {
                            return;
                        }
                        
                    }
                ],
            ],
        ],
    ]); ?>


</div>