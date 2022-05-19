<?php

namespace app\models;

use Yii;

class AutomobileForm extends yii\base\Model
{
    public $id;
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
            [['customer_id', 'id'], 'integer'],
            [['vin'], 'string', 'max' => 17],
            [['year'], 'string', 'max' => 20],
            [['make', 'model'], 'string', 'max' => 128],
            [['motor_number'], 'number'],
        ];
    }

    public static function automobileToForm($automobile, $model)
    {
        //$model = new AutomobileForm();
        if ($automobile->id) {
            $model->id = $automobile->id;
        }
        $model->vin = $automobile->vin;
        $model->make = $automobile->make;
        $model->model = $automobile->model;
        $model->year = $automobile->year;
        $model->customer_id = Owns::find()->where(['automobile_id' => $automobile->id])->one()->customer_id;
        $model->motor_number = $automobile->motor_number;
        return $model;
    }
}
