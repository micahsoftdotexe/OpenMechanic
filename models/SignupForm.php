<?php

namespace app\models;
use Yii;

class SignupForm extends yii\base\Model
{
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $password_repeat;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'username', 'password', 'password_repeat'], 'required'],
            [['first_name', 'last_name', 'username'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }
}
