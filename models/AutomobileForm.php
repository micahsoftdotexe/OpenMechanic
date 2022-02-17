<?php

namespace app\models;

use Yii;

class AutomobileForm extends yii\base\Model
{
    public $vin;
    public $make;
    public $model;
    public $year;
    public $customer_id;
    public $motor_number;

    public function rules()
    {
        return [
            [['vin', 'make', 'model', 'year', 'motor_number', 'customer_id'], 'required'],
        ];
    }
}