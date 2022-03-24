<?php
namespace models;

use app\models\Labor;

class LaborTest extends \Codeception\Test\Unit
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
        //order_id not added
        $labor = new Labor();
        $labor->description = 'test';
        $labor->price = 1.2;
        $this->assertFalse($labor->validate());

        //description not added
        $labor = new Labor();
        $labor->order_id = 1;
        $labor->price = 1.2;
        $this->assertFalse($labor->validate());

        //price not added
        $labor = new Labor();
        $labor->order_id = 1;
        $labor->description = 'test';
        $this->assertFalse($labor->validate());

        //order_id not not integer
        $labor = new Labor();
        $labor->order_id = 'a';
        $labor->description = 'test';
        $labor->price = 1.2;
        $this->assertFalse($labor->validate());

        //description not not string
        $labor = new Labor();
        $labor->order_id = 1;
        $labor->description = 1;
        $labor->price = 1.2;
        $this->assertFalse($labor->validate());

        //price not not integer
        $labor = new Labor();
        $labor->order_id = 1;
        $labor->description = 'test';
        $labor->price = 'a';
        $this->assertFalse($labor->validate());

        //notes not not string
        $labor = new Labor();
        $labor->order_id = 1;
        $labor->description = 'test';
        $labor->price = 1.2;
        $labor->notes = 1;
        $this->assertFalse($labor->validate());

        //order_id not exists
        $labor = new Labor();
        $labor->order_id = 9;
        $labor->description = 'test';
        $labor->price = 1.2;
        $this->assertFalse($labor->validate());

        //valid
        $labor = new Labor();
        $labor->order_id = 1;
        $labor->description = 'test';
        $labor->price = 1.2;
        $this->assertTrue($labor->validate());
    }
}
