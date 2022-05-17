<?php

use yii\db\Migration;

/**
 * Class m220425_210155_seed_test_data
 */
class m220425_210155_update_rbac1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $admin =  $auth->getRole('admin');
        $shopManager = $auth->getRole('shopManager');
        $employee = $auth->getRole('employee');

        $deleteCustomer = $auth->createPermission('deleteCustomer');
        $deleteCustomer->description = 'Delete Customer';
        $auth->add($deleteCustomer);

        $auth->addChild($admin, $deleteCustomer);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //$this->delete('user', ['username' => 'manager']);
        //$this->delete('user', ['username' => 'demo']);
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
