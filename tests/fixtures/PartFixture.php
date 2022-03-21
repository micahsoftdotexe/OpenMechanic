<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class PartFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Part';
    public $dataFile = '@app/tests/fixtures/_data/part.php';
    public $depends = ['app\tests\fixtures\WorkorderFixture'];
}
