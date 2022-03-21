<?php
namespace models;
use \app\models\SignupForm;
class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        //first_name not added
        $signupForm = new SignupForm();
        $signupForm->last_name = 'test';
        $signupForm->username = 'test';
        $signupForm->password = 'test12';
        $signupForm->password_repeat = 'test12';
        $this->assertFalse($signupForm->validate());

        //last_name not added
        $signupForm = new SignupForm();
        $signupForm->first_name = 'test';
        $signupForm->username = 'test';
        $signupForm->password = 'test12';
        $signupForm->password_repeat = 'test12';
        $this->assertFalse($signupForm->validate());

        //username not added
        $signupForm = new SignupForm();
        $signupForm->first_name = 'test';
        $signupForm->last_name = 'test';
        $signupForm->password = 'test12';
        $signupForm->password_repeat = 'test12';
        $this->assertFalse($signupForm->validate());

        //password not added
        $signupForm = new SignupForm();
        $signupForm->first_name = 'test';
        $signupForm->last_name = 'test';
        $signupForm->username = 'test';
        $signupForm->password_repeat = 'test12';
        $this->assertFalse($signupForm->validate());

        //password_repeat not added
        $signupForm = new SignupForm();
        $signupForm->first_name = 'test';
        $signupForm->last_name = 'test';
        $signupForm->username = 'test';
        $signupForm->password = 'test12';
        $this->assertFalse($signupForm->validate());

        //password_repeat not equal to password
        $signupForm = new SignupForm();
        $signupForm->first_name = 'test';
        $signupForm->last_name = 'test';
        $signupForm->username = 'test';
        $signupForm->password = 'test12';
        $signupForm->password_repeat = 'test23';
        $this->assertFalse($signupForm->validate());

        //first_name not string
        $signupForm = new SignupForm();
        $signupForm->first_name = 1;
        $signupForm->last_name = 'test';
        $signupForm->username = 'test';
        $signupForm->password = 'test12';
        $signupForm->password_repeat = 'test12';
        $this->assertFalse($signupForm->validate());

        //last_name not string
        $signupForm = new SignupForm();
        $signupForm->first_name = 'test';
        $signupForm->last_name = 1;
        $signupForm->username = 'test';
        $signupForm->password = 'test12';
        $signupForm->password_repeat = 'test12';
        $this->assertFalse($signupForm->validate());

        //username not string
        $signupForm = new SignupForm();
        $signupForm->first_name = 'test';
        $signupForm->last_name = 'test';
        $signupForm->username = 1;
        $signupForm->password = 'test12';
        $signupForm->password_repeat = 'test12';
        $this->assertFalse($signupForm->validate());

        //password not long enough
        $signupForm = new SignupForm();
        $signupForm->first_name = 'test';
        $signupForm->last_name = 'test';
        $signupForm->username = 'test';
        $signupForm->password = 'test';
        $signupForm->password_repeat = 'test';
        $this->assertFalse($signupForm->validate());

        //valid
        $signupForm = new SignupForm();
        $signupForm->first_name = 'test';
        $signupForm->last_name = 'test';
        $signupForm->username = 'test';
        $signupForm->password = 'test12';
        $signupForm->password_repeat = 'test12';
        $this->assertTrue($signupForm->validate());
    }
}