<?php
namespace models;
use \app\models\Workorder;

class workorderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures()
    {   return [
            'Workorders' => [
                'class' => \app\tests\fixtures\WorkorderFixture::className(),
                'dataFile' => codecept_data_dir() . 'workorder.php',
            ],
            'Parts' => [
                'class' => \app\tests\fixtures\PartFixture::className(),
                'dataFile' => codecept_data_dir() . 'part.php',
                //'depends' => ['Workorders'],
            ],
            'Labor' => [
                'class' => \app\tests\fixtures\LaborFixture::className(),
                'dataFile' => codecept_data_dir() . 'labor.php',
            ],
            'Owns' => [
                'class' => \app\tests\fixtures\OwnFixture::className(),
                'dataFile' => codecept_data_dir() . 'owns.php',
                //'depends' => ['Parts'],
            ],
            'Customers' => [
                'class' => \app\tests\fixtures\CustomerFixture::className(),
                'dataFile' => codecept_data_dir() . 'customer.php',
                //'depends' => ['Owns'],
            ],
            'Automobiles' => [
                'class' => \app\tests\fixtures\AutomobileFixture::className(),
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
        $workorder = new Workorder();
        $workorder->automobile_id = 1;
        $workorder->odometer_reading = 1;
        $workorder->stage_id = 1;
        $this->tester->assertFalse($workorder->validate());

        //without automobile_id
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->odometer_reading = 1;
        $workorder->stage_id = 1;
        $this->tester->assertFalse($workorder->validate());

        //without odometer_reading
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->automobile_id = 1;
        $workorder->stage_id = 1;
        $this->tester->assertFalse($workorder->validate());

        //without stage_id
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->automobile_id = 1;
        $workorder->odometer_reading = 1;
        $this->tester->assertFalse($workorder->validate());

        //customer_id is not an integer
        $workorder = new Workorder();
        $workorder->customer_id = 'a';
        $workorder->automobile_id = 1;
        $workorder->odometer_reading = 1;
        $workorder->stage_id = 1;
        $this->tester->assertFalse($workorder->validate());

        //automobile_id is not an integer
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->automobile_id = 'a';
        $workorder->odometer_reading = 1;
        $workorder->stage_id = 1;
        $this->tester->assertFalse($workorder->validate());

        //paid_in_full is not an integer
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->automobile_id = 1;
        $workorder->odometer_reading = 1;
        $workorder->paid_in_full = 'a';
        $workorder->stage_id = 1;
        $this->tester->assertFalse($workorder->validate());

        //tax is not a number
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->automobile_id = 1;
        $workorder->odometer_reading = 1;
        $workorder->tax = 'a';
        $workorder->stage_id = 1;
        $this->tester->assertFalse($workorder->validate());

        //amount_paid is not a number
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->automobile_id = 1;
        $workorder->odometer_reading = 1;
        $workorder->amount_paid = 'a';
        $workorder->stage_id = 1;
        $this->tester->assertFalse($workorder->validate());

        //odometer_reading is not an integer
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->automobile_id = 1;
        $workorder->odometer_reading = 'a';
        $workorder->stage_id = 1;
        $this->tester->assertFalse($workorder->validate());
    }

    public function testSave()
    {
        $workorder = new Workorder();
        $workorder->customer_id = 2;
        $workorder->stage_id = 1;
        $workorder->automobile_id = 3;
        $workorder->odometer_reading = 1;
        $workorder->paid_in_full = 1;
        $workorder->tax = 1;
        $workorder->amount_paid = 1;
        $workorder->save();
        $this->tester->seeRecord(Workorder::class, ['customer_id' => 2]);
    }

    public function testFullName()
    {
        $workorder = Workorder::findOne(1);
        $this->tester->assertEquals('Customer 1', $workorder->fullName);
    }
}