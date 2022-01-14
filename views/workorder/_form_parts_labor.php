<h1> Parts and Labor </h1>
<div id="partsdiv">
    <h2>Parts</h2>
    <?= yii\grid\GridView::widget([
        'id' => 'partGrid',
        'dataProvider' => $partDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'part_number',
            'price',
            'quantity',
            [
                'label' => 'Quantity Type',
                'attribute' => 'quantity_type_id',
                'value'=> function($model) {
                    return \app\models\QuantityType::findOne(['id' => $model->quantity_type_id ])->description;
                }
            ]
        ]
    ])?>
</div>
<div id="labordiv">
    <h2>Labor</h2>
    <?= yii\grid\GridView::widget([
        'id' => 'laborGrid',
        'dataProvider' => $laborDataProvider
    ])?>
</div>
