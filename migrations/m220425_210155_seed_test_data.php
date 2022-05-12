<?php

use yii\db\Migration;
use app\models\User;

/**
 * Class m220425_210155_seed_test_data
 */
class m220425_210155_seed_test_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $this->batchInsert('user', ['first_name', 'last_name', 'username', 'password', 'auth_key', 'status'], [
            ['manager', 'manager', 'manager', Yii::$app->security->generatePasswordHash('manager'), 'manager', 1],
        ]);
        $this->batchInsert('user', ['first_name', 'last_name', 'username', 'password', 'auth_key', 'status'], [
            ['demo', 'demo', 'demo', Yii::$app->security->generatePasswordHash('demo'), 'demo', 1],
        ]);
        if (User::findOne(['username' => 'manager'])) {
            $manager = $auth->getRole('shopManager');
            $auth->assign($manager, User::findOne(['username' => 'manager'])->id);
        }
        if (User::findOne(['username' => 'demo'])) {
            $employee = $auth->getRole('employee');
            $auth->assign($employee, User::findOne(['username' => 'demo'])->id);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['username' => 'manager']);
        $this->delete('user', ['username' => 'demo']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220425_210155_seed_test_data cannot be reverted.\n";

        return false;
    }
    */
}
