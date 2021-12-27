<?php

namespace app\models;

use Yii;

class CustomerForm extends yii\base\Model
{
    public $firstName;
    public $lastName;
    public $phoneNumber;
    public $streetAddress;
    public $city;
    public $zip;
    public $state;
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'phoneNumber', 'streetAddress', 'city', 'zip', 'state'], 'required'],
        ];
    }
}
