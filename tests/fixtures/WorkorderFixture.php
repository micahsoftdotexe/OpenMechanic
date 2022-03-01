<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class WorkorderFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Workorder';
    public $dataFile = '@app/tests/fixtures/_data/workorder.php';
}