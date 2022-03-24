<?php
namespace models;
use app\models\Stage;

class StageTest extends \Codeception\Test\Unit
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


    public function testValidation()
    {
        // title not string
        $stage = new Stage();
        $stage->title = 1;
        $this->tester->assertFalse($stage->validate());

        //valid
        $stage = new Stage();
        $stage->title = 'test';
        $this->tester->assertTrue($stage->validate());
    }
}