<?php
namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class PhoneNumberFixture extends ActiveFixture
{
    public $modelClass = 'app\models\PhoneNumber';
    public $dataFile = '@app/tests/fixtures/_data/customer.php';
}
