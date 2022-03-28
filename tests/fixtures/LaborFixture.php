<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class LaborFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Labor';
    public $dataFile = '@app/tests/fixtures/_data/labor.php';
    public $depends = ['app\tests\fixtures\OrderFixture'];
}
