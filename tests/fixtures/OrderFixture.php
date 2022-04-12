<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class OrderFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Order';
    public $dataFile = '@app/tests/fixtures/_data/order.php';
    public $depends = ['app\tests\fixtures\AutomobileFixture','app\tests\fixtures\CustomerFixture', 'app\tests\fixtures\OwnFixture'];
}
