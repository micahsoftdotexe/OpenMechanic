<?php

use yii\db\Migration;
use app\models\User;
/**
 * Class m220225_154852_init_rbac
 */
class m220225_154852_init_rbac extends Migration
{
    private function assignAdminUserToRoles()
    {
        $auth = Yii::$app->authManager;
        if (User::findOne(['username' => 'admin'])) {
            $admin = $auth->getRole('admin');
            $auth->assign($admin, User::findOne(['username' => 'admin'])->id);
        }
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \Yii::$app->runAction('migrate', ['migrationPath' => '@yii/rbac/migrations/', 'interactive' => false]);
        // create order permission
        // create customer permission
        // edit customer permission
        // delete customer permission
        // create automobile permission
        // edit automobile permission
        // delete automobile permission
        // create notes permission
        //! edit own notes permission
        //! delete own notes permission
        // delete notes permission
        // create user permission
        // edit user permission
        //! edit own user permission
        //! change stage permission
        // edit user roles permission
        // create labor permission
        // edit labor permission
        // delete labor permission
        // create parts permission
        // edit parts permission
        // delete parts permission
        // view order permission


        $auth = Yii::$app->authManager;
        //add rules
        $noteAuthor = new \app\rbac\NoteAuthorRule;
        $auth->add($noteAuthor);
        $userEdit = new \app\rbac\UserEditRule;
        $auth->add($userEdit);
        $stageChange = new \app\rbac\StageChangeRule;
        $auth->add($stageChange);

        //permissions
        $createOrder = $auth->createPermission('createOrder');
        $createOrder->description = 'Create Order';
        $auth->add($createOrder);

        $editOrder = $auth->createPermission('editOrder');
        $editOrder->description = 'Edit Order';
        $auth->add($editOrder);

        $deleteOrder = $auth->createPermission('deleteOrder');
        $deleteOrder->description = 'Delete Order';
        $auth->add($deleteOrder);

        $createCustomer = $auth->createPermission('createCustomer');
        $createCustomer->description = 'Create Customer';
        $auth->add($createCustomer);

        $editCustomer = $auth->createPermission('editCustomer');
        $editCustomer->description = 'Edit Customer';
        $auth->add($editCustomer);

        $deleteCustomer = $auth->createPermission('deleteCustomer');
        $deleteCustomer->description = 'Delete Customer';
        $auth->add($deleteCustomer);

        $createAuto = $auth->createPermission('createAuto');
        $createAuto->description = 'Create Automobile';
        $auth->add($createAuto);

        $editAuto = $auth->createPermission('editAuto');
        $editAuto->description = 'Edit Automobile';
        $auth->add($editAuto);

        $deleteAuto = $auth->createPermission('deleteAuto');
        $deleteAuto->description = 'Delete Automobile';
        $auth->add($deleteAuto);

        $createNote = $auth->createPermission('createNote');
        $createNote->description = 'Create Note';
        $auth->add($createNote);

        $editNote = $auth->createPermission('editOwnNote');
        $editNote->description = 'Edit Own Note';
        $editNote->ruleName = $noteAuthor->name;
        $auth->add($editNote);

        $deleteNote = $auth->createPermission('deleteOwnNote');
        $deleteNote->description = 'Delete Own Note';
        $deleteNote->ruleName = $noteAuthor->name;
        $auth->add($deleteNote);

        $deleteNote2 = $auth->createPermission('deleteNote');
        $deleteNote2->description = 'Delete Note';
        $auth->add($deleteNote2);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create User';
        $auth->add($createUser);

        $editUser = $auth->createPermission('editOwnUser');
        $editUser->description = 'Edit Own User';
        $editUser->ruleName = $userEdit->name;
        $auth->add($editUser);

        $editUserRoles = $auth->createPermission('editUserRoles');
        $editUserRoles->description = 'Edit User Roles';
        $auth->add($editUserRoles);

        $createLabor = $auth->createPermission('createLabor');
        $createLabor->description = 'Create Labor';
        $auth->add($createLabor);

        $editLabor = $auth->createPermission('editLabor');
        $editLabor->description = 'Edit Labor';
        $auth->add($editLabor);

        $deleteLabor = $auth->createPermission('deleteLabor');
        $deleteLabor->description = 'Delete Labor';
        $auth->add($deleteLabor);

        $createParts = $auth->createPermission('createPart');
        $createParts->description = 'Create Parts';
        $auth->add($createParts);

        $editParts = $auth->createPermission('editPart');
        $editParts->description = 'Edit Parts';
        $auth->add($editParts);

        $deleteParts = $auth->createPermission('deletePart');
        $deleteParts->description = 'Delete Parts';
        $auth->add($deleteParts);

        $viewOrder = $auth->createPermission('viewOrder');
        $viewOrder->description = 'View Order';
        $auth->add($viewOrder);

        $changeStage = $auth->createPermission('changeStage');
        $changeStage->description = 'Change Stage';
        $changeStage->ruleName = $stageChange->name;
        $auth->add($changeStage);

        //create employee role
        $employee = $auth->createRole('employee');
        $auth->add($employee);
        $auth->addChild($employee, $editUser);
        $auth->addChild($employee, $createNote);
        $auth->addChild($employee, $editNote);
        $auth->addChild($employee, $deleteNote);
        $auth->addChild($employee, $viewOrder);
        $auth->addChild($employee, $changeStage);

        //create shop manager role
        $shopManager = $auth->createRole('shopManager');
        $auth->add($shopManager);
        $auth->addChild($shopManager, $employee);
        $auth->addChild($shopManager, $createOrder);
        $auth->addChild($shopManager, $editOrder);
        $auth->addChild($shopManager, $createAuto);
        $auth->addChild($shopManager, $createCustomer);
        $auth->addChild($shopManager, $editAuto);
        $auth->addChild($shopManager, $editCustomer);
        $auth->addChild($shopManager, $createLabor);
        $auth->addChild($shopManager, $editLabor);
        $auth->addChild($shopManager, $deleteLabor);
        $auth->addChild($shopManager, $createParts);
        $auth->addChild($shopManager, $editParts);
        $auth->addChild($shopManager, $deleteParts);

        //create admin role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $shopManager);
        $auth->addChild($admin, $employee);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $editUserRoles);
        $auth->addChild($admin, $deleteOrder);
        $auth->addChild($admin, $deleteCustomer);

        $this->assignAdminUserToRoles();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $success = false;
        $authManager = Yii::$app->authManager;
        $performLocalDowngrade = true;  // Specify whether to perform downgrade here.  If not here, delegate that to @yii/rbac/migrations migration script to avoid duplication.
        if ($performLocalDowngrade) {
            echo "\nDropping RBAC tables\n";
            $this->dropTable($authManager->assignmentTable);
            $this->dropTable($authManager->itemChildTable);
            $this->dropTable($authManager->itemTable);
            $this->dropTable($authManager->ruleTable);
            Yii::$app->db->createCommand()->delete('migration', ['version' => 'm200409_110543_rbac_update_mssql_trigger'])->execute();
            Yii::$app->db->createCommand()->delete('migration', ['version' => 'm180523_151638_rbac_updates_indexes_without_prefix'])->execute();
            Yii::$app->db->createCommand()->delete('migration', ['version' => 'm170907_052038_rbac_add_index_on_auth_assignment_user_id'])->execute();
            Yii::$app->db->createCommand()->delete('migration', ['version' => 'm140506_102106_rbac_init'])->execute();
            Yii::$app->db->createCommand()->delete('migration', ['version' => 'm180409_110000_init_rbac'])->execute();

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
