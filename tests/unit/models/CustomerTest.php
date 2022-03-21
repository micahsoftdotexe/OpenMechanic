<?php
namespace models;

use \app\models\Customer;

class CustomerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures()
    {   return [
            'Workorders' => [
                'class' => \app\tests\fixtures\WorkorderFixture::class,
                'dataFile' => codecept_data_dir() . 'workorder.php',
            ],
            'Parts' => [
                'class' => \app\tests\fixtures\PartFixture::class,
                'dataFile' => codecept_data_dir() . 'part.php',
                //'depends' => ['Workorders'],
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
        // without first_name
        $customer = new Customer();
        $customer->last_name = 'Smith';
        $this->assertFalse($customer->validate());

        // without last_name
        $customer = new Customer();
        $customer->first_name = 'John';
        $this->assertFalse($customer->validate());

        // street_address is not string
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->street_address = 1;
        $this->assertFalse($customer->validate());

        // city is not string
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->city = 1;
        $this->assertFalse($customer->validate());

        // state is not string
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->state = 1;
        $this->assertFalse($customer->validate());

        //state is not in array
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->state = 'ZZ';
        $this->assertFalse($customer->validate());

        // zip is not string
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->zip = 1;
        $this->assertFalse($customer->validate());

        // zip is more than 10 characters
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->zip = '12345678901';
        $this->assertFalse($customer->validate());

        // zip does not match regex
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->zip = '673';
        $this->assertFalse($customer->validate());

        // phone is not string
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->phone_number_1 = 1;
        $this->assertFalse($customer->validate());

        // phone is more than 15 characters
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->phone_number_1 = '123456789012345';
        $this->assertFalse($customer->validate());

        // phone does not match regex
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $customer->phone_number_1 = '12345678901';
        $this->assertFalse($customer->validate());

        // valid
        $customer = new Customer();
        $customer->first_name = 'John';
        $customer->last_name = 'Smith';
        $this->assertTrue($customer->validate());
    }
}
