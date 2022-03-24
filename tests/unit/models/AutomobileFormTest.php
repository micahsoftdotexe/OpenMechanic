<?php
namespace models;
use \app\models\AutomobileForm;

class AutomobileFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures()
    {   return [
            'Orders' => [
                'class' => \app\tests\fixtures\OrderFixture::class,
                'dataFile' => codecept_data_dir() . 'order.php',
            ],
            'Parts' => [
                'class' => \app\tests\fixtures\PartFixture::class,
                'dataFile' => codecept_data_dir() . 'part.php',
                //'depends' => ['Orders'],
            ],
            'Labor' => [
                'class' => \app\tests\fixtures\LaborFixture::class,
                'dataFile' => codecept_data_dir() . 'labor.php',
            ],
            'Owns' => [
                'class' => \app\tests\fixtures\OwnFixture::class,
                'dataFile' => codecept_data_dir() . 'owns.php',
                //'depends' => ['Parts'],
            ],
            'Customers' => [
                'class' => \app\tests\fixtures\CustomerFixture::class,
                'dataFile' => codecept_data_dir() . 'customer.php',
                //'depends' => ['Owns'],
            ],
            'Automobiles' => [
                'class' => \app\tests\fixtures\AutomobileFixture::class,
                'dataFile' => codecept_data_dir() . 'automobile.php',
                //'depends' => ['Owns'],
            ],
        ];
    }
    // tests
    public function testValidation()
    {
        //vin not added
        $automobile = new AutomobileForm();
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //make not added
        $automobile = new AutomobileForm();
        $automobile->vin = '12345678901234567';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //model not added
        $automobile = new AutomobileForm();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //year not added
        $automobile = new AutomobileForm();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //motor_num not added
        $automobile = new AutomobileForm();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $this->assertFalse($automobile->validate());

        //year not a number
        $automobile = new AutomobileForm();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = "Hello";
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //motor_num not a number
        $automobile = new AutomobileForm();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 'hello';
        $this->assertFalse($automobile->validate());

        //vin not string
        $automobile = new AutomobileForm();
        $automobile->vin = 12345678901234567;
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //make not string
        $automobile = new AutomobileForm();
        $automobile->vin = '12345678901234567';
        $automobile->make = 12345678901234567;
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //model not string
        $automobile = new AutomobileForm();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 12345678901234567;
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //valid
        $automobile = new AutomobileForm();
        $automobile->customer_id = 1;
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertTrue($automobile->validate());
    }
}
