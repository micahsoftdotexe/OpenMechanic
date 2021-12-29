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

    public function rules()
    {
        return [
            [['vin', 'make', 'model', 'year', 'customer_id'], 'required'],
        ];
    }
}
