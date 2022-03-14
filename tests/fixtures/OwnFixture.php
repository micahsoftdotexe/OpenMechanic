<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class OwnFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Owns';
    public $dataFile = '@app/tests/fixtures/_data/owns.php';
    public $depends = ['app\tests\fixtures\AutomobileFixture','app\tests\fixtures\CustomerFixture'];
}
