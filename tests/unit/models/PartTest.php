<?php
namespace models;

use app\models\Part;

class PartTest extends \Codeception\Test\Unit
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

    // tests
    public function testValidation()
    {
        // without price
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());

        // without description
        $part = new Part();
        $part->margin = 1;
        $part->price = 1;
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());

        // without margin
        $part = new Part();
        $part->price = 1;
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());

        // without part_number
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->price = 1;
        $part->quantity = 1;
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());

        // without quantity
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->part_number = 'test';
        $part->price = 1;
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());

        // without workorder_id
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->price = 1;
        $this->tester->assertFalse($part->validate());

        // workorder_id not found
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->price = 1;
        $part->workorder_id = 999;
        $this->tester->assertFalse($part->validate());

        // workorder_id not integer
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->price = 1;
        $part->workorder_id = 'test';
        $this->tester->assertFalse($part->validate());

        // quantity_type_id not integer
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 'test';
        $part->price = 1;
        $part->workorder_id = 1;
        $part->quantity_type_id = 'test';
        $this->tester->assertFalse($part->validate());

        // price not number
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->price = 'test';
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());

        // margin not number
        $part = new Part();
        $part->margin = 'test';
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->price = 1;
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());

        // quantity not a number
        $part = new Part();
        $part->margin = 'test';
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->price = 1;
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());

        // part_number not a string
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->part_number = 1;
        $part->quantity = 1;
        $part->price = 1;
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());

        // description not a string
        $part = new Part();
        $part->margin = 1;
        $part->description = 1;
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->price = 1;
        $part->workorder_id = 1;
        $this->tester->assertFalse($part->validate());


        //valid
        $part = new Part();
        $part->margin = 1;
        $part->description = 'test';
        $part->part_number = 'test';
        $part->quantity = 1;
        $part->price = 1;
        $part->workorder_id = 1;
        $this->tester->assertTrue($part->validate());

    }
}