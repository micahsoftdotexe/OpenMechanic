<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class AutomobileFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Automobile';
    public $dataFile = '@app/tests/fixtures/_data/automobile.php';
}
