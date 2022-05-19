<?php
use yii\grid\GridView;
use yii\helpers\Html;

?>
<p>
    <?= Html::a(Yii::t('app', 'Create Automobile'), ['/automobile/create', 'customer_id' => $customer_id], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'automobile-grid',
    'columns' => [
        'make',
        'model',
        'year',
        'vin',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}{edit}{delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('editAuto')) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['automobile/customer-edit', 'id' => $model->id], [
                            'title' => Yii::t('app', 'Edit Automobile'),
                        ]);
                    } else {
                        return;
                    }
                },
                'view' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['automobile/view', 'id' => $model->id], [
                        'title' => Yii::t('app', 'View Automobile'),
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('deleteAuto')) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/automobile/delete', 'id' => $model->id], [
                            'title' => Yii::t('app', 'Delete Automobile'),
                        ]);
                    } else {
                        return;
                    }
                }
            ],
        ],

    ]
]) ?>