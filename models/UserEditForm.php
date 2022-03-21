<?php
namespace app\models;
use Yii;

class UserEditForm extends yii\base\Model
{
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $password_repeat;
    public $roles;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'username'], 'required'],
            [['first_name', 'last_name', 'username'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function getRoles()
    {
        $returnRoles = [];
        foreach ((array_keys(Yii::$app->authManager->getRoles())) as $role) {
            $returnRoles[$role] = $role;
        }
        return $returnRoles;
    }

    public function getUserRoles()
    {
        return array_keys(Yii::$app->authManager->getRolesByUser($this->id));
    }
}
