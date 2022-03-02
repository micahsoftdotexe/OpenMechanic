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
        $this->tester->assertFalse($workorder->validate());

        //without automobile_id
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->odometer_reading = 1;
        $this->tester->assertFalse($workorder->validate());

        //without odometer_reading
        $workorder = new Workorder();
        $workorder->customer_id = 1;
        $workorder->automobile_id = 1;
        $this->tester->assertFalse($workorder->validate());


    }
}