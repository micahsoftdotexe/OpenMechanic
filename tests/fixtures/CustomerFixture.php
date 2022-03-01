<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class CustomerFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Customer';
    public $dataFile = '@app/tests/fixtures/_data/customer.php';
}