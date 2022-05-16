<?php 
use yii\grid\GridView;
use yii\helpers\Html;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'automobile-grid',
    'columns' => [
        'make',
        'model',
        'year',
        'vin'

    ]
]) ?>