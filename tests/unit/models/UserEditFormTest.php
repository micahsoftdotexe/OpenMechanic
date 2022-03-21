<?php
namespace models;
use \app\models\UserEditForm;

class UserEditFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidate()
    {
        //first_name not added
        $userEditForm = new UserEditForm();
        $userEditForm->last_name = 'test';
        $userEditForm->username = 'test';
        $userEditForm->password = 'test12';
        $userEditForm->password_repeat = 'test12';
        $this->assertFalse($userEditForm->validate());

        //last_name not added
        $userEditForm = new UserEditForm();
        $userEditForm->first_name = 'test';
        $userEditForm->username = 'test';
        $userEditForm->password = 'test12';
        $userEditForm->password_repeat = 'test12';
        $this->assertFalse($userEditForm->validate());

        //username not added
        $userEditForm = new UserEditForm();
        $userEditForm->first_name = 'test';
        $userEditForm->last_name = 'test';
        $userEditForm->password = 'test12';
        $userEditForm->password_repeat = 'test12';
        $this->assertFalse($userEditForm->validate());

        //password_repeat not equal to password
        $userEditForm = new UserEditForm();
        $userEditForm->first_name = 'test';
        $userEditForm->last_name = 'test';
        $userEditForm->password = 'test12';
        $userEditForm->password_repeat = 'test23';
        $this->assertFalse($userEditForm->validate());

        //password not long enough
        $userEditForm = new UserEditForm();
        $userEditForm->first_name = 'test';
        $userEditForm->last_name = 'test';
        $userEditForm->username = 'test';
        $userEditForm->password = 'test';
        $userEditForm->password_repeat = 'test';
        $this->assertFalse($userEditForm->validate());

        //valid
        $userEditForm = new UserEditForm();
        $userEditForm->first_name = 'test';
        $userEditForm->last_name = 'test';
        $userEditForm->username = 'test';
        $userEditForm->password = 'test12';
        $userEditForm->password_repeat = 'test12';
        $this->assertTrue($userEditForm->validate());

        //valid
        $userEditForm = new UserEditForm();
        $userEditForm->first_name = 'test';
        $userEditForm->last_name = 'test';
        $userEditForm->username = 'test';
        $this->assertTrue($userEditForm->validate());
    }
}
