<?php

use yii\helpers\Html;
use yii\grid\GridView;
?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'automobile-grid',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
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
            'attribute' => 'date',
            'filter' => \yii\jui\DatePicker::widget([
                //'model' => $searchModel,
                'attribute' => 'date',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'class'=>'form-control'
                ],
            ]),
            'format' => 'html',
        ],
        [
            'attribute' => 'stage',
            'value' => function($model) {
                return \app\models\Order::$stages[$model->stage];
            },
            'filter' => \app\models\Order::$stages,
        ],
        [
            'attribute' => 'subtotal',
            'value' => function($model) {
                return '$' . number_format(round($model->subtotal, 2), 2);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{edit}{delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('editOrder')) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['order/edit', 'id' => $model->id], [
                            'title' => Yii::t('app', 'Edit Order'),
                        ]);
                    } else {
                        return;
                    }
                },
                'delete' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('deleteOrder')) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['order/delete', 'id' => $model->id], [
                            'title' => Yii::t('app', 'Delete Order'),
                        ]);
                    } else {
                        return;
                    }
                }
            ],
        ],

    ]
    ]);