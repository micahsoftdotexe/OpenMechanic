<?php

use yii\db\Migration;

/**
 * Class m220225_154852_init_rbac
 */
class m220225_154852_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \Yii::$app->runAction('migrate', ['migrationPath' => '@yii/rbac/migrations/', 'interactive' => false]);
        // create work order permission
        // create customer permission
        // edit customer permission
        // create automobile permission
        // edit automobile permission
        // create notes permission
        // edit notes permission
        //! edit own notes permission
        // create user permission
        // edit user permission
        //! edit own user permission
        // edit user roles permission



        $auth = Yii::$app->authManager;

        //create employee role
        $employee = $auth->createRole('employee');
        $auth->add($employee);

        //create shop manager role
        $shopManager = $auth->createRole('shopManager');
        $auth->add($shopManager);
        $auth->addChild($shopManager, $employee);

        //create admin role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $employee);
        $auth->addChild($admin, $shopManager);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $success = false;
        $performLocalDowngrade = true;  // Specify whether to perform downgrade here.  If not here, delegate that to @yii/rbac/migrations migration script to avoid duplication.
        if ($performLocalDowngrade) {
            echo "\nDropping RBAC tables\n";
            \app\helpers\DbHelper::dropRbacTables();

            $success = true;
        } else {
            // Execute Yii RBAC migration @yii/rbac/migrations/m140506_102106_rbac_init
            //\Yii::$app->runAction('migrate/down', ['migrationPath' => '@yii/rbac/migrations/', 'interactive' => false]);

            $success = true;  // Do not perform downgrade here.  Delegate that to @yii/rbac/migrations migration script to avoid duplication.
        }
        return $success;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220225_154852_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
