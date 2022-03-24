<?php
namespace models;
use \app\models\Automobile;

class AutomobileTest extends \Codeception\Test\Unit
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
        $automobile = new Automobile();
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //make not added
        $automobile = new Automobile();
        $automobile->vin = '12345678901234567';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //model not added
        $automobile = new Automobile();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //year not added
        $automobile = new Automobile();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //motor_num not added
        $automobile = new Automobile();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $this->assertFalse($automobile->validate());

        //year not a number
        $automobile = new Automobile();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = "Hello";
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //motor_num not a number
        $automobile = new Automobile();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 'hello';
        $this->assertFalse($automobile->validate());

        //vin not string
        $automobile = new Automobile();
        $automobile->vin = 12345678901234567;
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //make not string
        $automobile = new Automobile();
        $automobile->vin = '12345678901234567';
        $automobile->make = 12345678901234567;
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //model not string
        $automobile = new Automobile();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 12345678901234567;
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertFalse($automobile->validate());

        //valid
        $automobile = new Automobile();
        $automobile->vin = '12345678901234567';
        $automobile->make = 'Honda';
        $automobile->model = 'Civic';
        $automobile->year = 2000;
        $automobile->motor_number = 1.2;
        $this->assertTrue($automobile->validate());

    }

    public function testGetIds() {
        $customer = $this->tester->grabFixture('Customers', 'customer1');
        $answer_ids = Automobile::getIds($customer->id);
        $automobiles = $customer->automobiles;
        foreach ($automobiles as $automobile) {
            $this->assertArrayHasKey($automobile->id, $answer_ids);
            $this->assertEquals($automobile->make.' '.$automobile->model.' '.$automobile->year, $answer_ids[$automobile->id]);
        }
    }
}
