<?php
return [
    'order1' => [
        'id'               => 1,
        'stage'            => 1,
        'customer_id'      => 1,
        'automobile_id'    => 1,
        'date'             => '2000-01-01',
        'odometer_reading' => 1234,
        'tax'              => \Yii::$app->params['sales_tax'],
    ],
    'order2' => [
        'id'               => 2,
        'stage'            => 4,
        'customer_id'      => 1,
        'automobile_id'    => 1,
        'date'             => '2000-01-02',
        'odometer_reading' => 12345,
        'tax'              => \Yii::$app->params['sales_tax'],

    ],
];
