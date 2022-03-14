<?php
namespace models;
use app\models\Note;


class noteTest extends \Codeception\Test\Unit
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
        //workorder_id not added
        $note = new Note();
        $note->text = 'test';
        $this->assertFalse($note->validate());

        //workorder_id not integer
        $note = new Note();
        $note->workorder_id = 'a';
        $note->text = 'test';
        $this->assertFalse($note->validate());

        //text not string
        $note = new Note();
        $note->workorder_id = 1;
        $note->text = 1;
        $this->assertFalse($note->validate());

        //workorder_id does not exist
        $note = new Note();
        $note->workorder_id = 9;
        $note->text = 'test';
        $this->assertFalse($note->validate());
    }
}