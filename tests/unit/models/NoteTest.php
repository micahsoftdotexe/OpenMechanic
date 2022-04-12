<?php
namespace models;
use app\models\Note;


class NoteTest extends \Codeception\Test\Unit
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
        $note = new Note();
        $note->text = 'test';
        $this->assertFalse($note->validate());

        //order_id not integer
        $note = new Note();
        $note->order_id = 'a';
        $note->text = 'test';
        $this->assertFalse($note->validate());

        //text not string
        $note = new Note();
        $note->order_id = 1;
        $note->text = 1;
        $this->assertFalse($note->validate());

        //order_id does not exist
        $note = new Note();
        $note->order_id = 9;
        $note->text = 'test';
        $this->assertFalse($note->validate());

        //valid
        $note = new Note();
        $note->order_id = 1;
        $note->text = 'test';
        $this->assertTrue($note->validate());
    }
}
