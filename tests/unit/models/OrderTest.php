<?php
namespace models;
use \app\models\Order;

class OrderTest extends \Codeception\Test\Unit
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

    // protected function _before()
    // {
    // }

    // protected function _after()
    // {
    // }

    // tests
    public function testValidation()
    {
        // without customer_id
        $order = new Order();
        $order->automobile_id = 1;
        $order->odometer_reading = 1;
        $order->stage_id = 1;
        $this->tester->assertFalse($order->validate());

        //without automobile_id
        $order = new Order();
        $order->customer_id = 1;
        $order->odometer_reading = 1;
        $order->stage_id = 1;
        $this->tester->assertFalse($order->validate());

        //without odometer_reading
        $order = new Order();
        $order->customer_id = 1;
        $order->automobile_id = 1;
        $order->stage_id = 1;
        $this->tester->assertFalse($order->validate());

        //without stage_id
        $order = new Order();
        $order->customer_id = 1;
        $order->automobile_id = 1;
        $order->odometer_reading = 1;
        $this->tester->assertFalse($order->validate());

        //customer_id is not an integer
        $order = new Order();
        $order->customer_id = 'a';
        $order->automobile_id = 1;
        $order->odometer_reading = 1;
        $order->stage_id = 1;
        $this->tester->assertFalse($order->validate());

        //automobile_id is not an integer
        $order = new Order();
        $order->customer_id = 1;
        $order->automobile_id = 'a';
        $order->odometer_reading = 1;
        $order->stage_id = 1;
        $this->tester->assertFalse($order->validate());

        //paid_in_full is not an integer
        $order = new Order();
        $order->customer_id = 1;
        $order->automobile_id = 1;
        $order->odometer_reading = 1;
        $order->paid_in_full = 'a';
        $order->stage_id = 1;
        $this->tester->assertFalse($order->validate());

        //tax is not a number
        $order = new Order();
        $order->customer_id = 1;
        $order->automobile_id = 1;
        $order->odometer_reading = 1;
        $order->tax = 'a';
        $order->stage_id = 1;
        $this->tester->assertFalse($order->validate());

        //amount_paid is not a number
        $order = new Order();
        $order->customer_id = 1;
        $order->automobile_id = 1;
        $order->odometer_reading = 1;
        $order->amount_paid = 'a';
        $order->stage_id = 1;
        $this->tester->assertFalse($order->validate());

        //odometer_reading is not an integer
        $order = new Order();
        $order->customer_id = 1;
        $order->automobile_id = 1;
        $order->odometer_reading = 'a';
        $order->stage_id = 1;
        $this->tester->assertFalse($order->validate());
    }

    public function testSave()
    {
        $order = new Order();
        $order->customer_id = 2;
        $order->stage_id = 1;
        $order->automobile_id = 3;
        $order->odometer_reading = 1;
        $order->paid_in_full = 1;
        $order->tax = 1;
        $order->amount_paid = 1;
        $order->save();
        $this->tester->seeRecord(Order::class, ['customer_id' => 2]);
    }

    public function testFullName()
    {
        $order = Order::findOne(1);
        $this->tester->assertEquals('Customer 1', $order->fullName);
    }
}