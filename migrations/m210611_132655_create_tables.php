<?php

use yii\db\Migration;

/**
 * Class m210611_132655_create_tables
 */
class m210611_132655_create_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    private function customerUp()
    {
        $this->createTable('customer',[
            'id' => $this->primaryKey(11),
            'firstName' => $this->string(50),
            'lastName' => $this->string(50),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    private function customer_down()
    {
        $this->dropTable('customer');    
    }
    /**
     * {@inheritdoc}
     */
    private function phone_number_up()
    {
        $this->createTable('phone_number',[
            // 'customer_id' => $this->primaryKey(11),
            // 'phone_type_id' => $this->primaryKey(),
            'customer_id' => $this->integer(11)->notNull(),
            'phone_type_id' => $this->integer(11)->notNull(),
            'phone_number' => $this->string(15),
        ]);
    }
     /**
     * {@inheritdoc}
     */
    private function phone_number_down()
    {
        
        $this->dropTable('phone_number');   
    }
    /**
     * {@inheritdoc}
     */
    private function phone_type_up()
    {
        $this->createTable('phone_type',[
            'id' => $this->primaryKey(11),
            'description' => $this->string(20),
        ]);
        
    }

     /**
     * {@inheritdoc}
     */
    private function phone_type_down()
    {
        //$this->addForeignKey('fk_phone_type_phone', 'phone_type');
        $this->dropTable('phone_type');   
    }
     /**
     * {@inheritdoc}
     */
    private function workorder_up()
    {
        $this->createTable('workorder',[
            'id' => $this->primaryKey(11),
            'customer_id' => $this->integer(11)->notNull(),
            'automobile_id' => $this->integer(11)->notNull(),
            'date' => $this->datetime(),
            'subtotal' => $this->decimal(10,2),
            'tax' => $this->decimal(10,2),
            'workorder_notes' => $this->text(),
            'amount_paid' => $this->decimal(10,2),
            'paid_in_full' => $this->boolean(),
            
        ]);
        
        
    }
    private function workorder_down(){
        
        // $this->addForeignKey('fk_workorder_automobile', 'workorder');
        $this->dropTable('workorder');
    }
    
    /**
     * {@inheritdoc}
     */
    public function address_up(){
        $this->createTable('address',[
            'customer_id' => $this->integer(11)->notNull(),
            'address_type_id' => $this->integer(11)->notNull(),
            'street_address_1' => $this->string(250)->notNull(),
            'street_address_2' => $this->string(250)->notNull(),
            'city' => $this->string(100)->notNull(),
            'zip' => $this->string(10)->notNull(),
            'state' => $this->string(2)->notNull(),
            
        ]);
        
    }

     /**
     * {@inheritdoc}
     */
    private function address_down()
    {
        
        $this->dropTable('address');   
    }

    /**
     * {@inheritdoc}
     */
    public function address_type_up(){
        $this->createTable('address_type',[
            'id' => $this->primaryKey(11),
            'address_description' => $this->string(20)->notNull(),
            
        ]);
    }

     /**
     * {@inheritdoc}
     */
    private function address_type_down()
    {
        $this->dropTable('address_type');   
    }

     /**
     * {@inheritdoc}
     */
    public function owns_up(){
        $this->createTable('owns',[
            'customer_id' => $this->integer(11)->notNull(),
            'automobile_id' => $this->integer(11)->notNull(),
            
        ]);
        
    }

     /**
     * {@inheritdoc}
     */
    private function owns_down()
    {
        
        $this->dropTable('owns');   
    }

     /**
     * {@inheritdoc}
     */
    public function automobile_up(){
        $this->createTable('automobile',[
            'id' => $this->primaryKey(11),
            'vin' => $this->string(17)->notNull(),
            'make' => $this->string(128)->notNull(),
            'model' => $this->string(128)->notNull(),
            'year' => $this->smallInteger()->notNull(),
        ]);
    }

     /**
     * {@inheritdoc}
     */
    private function automobile_down()
    {
        $this->dropTable('automobile');   
    }

    /**
     * {@inheritdoc}
     */
    public function labor_up(){
        $this->createTable('labor',[
            'id' => $this->primaryKey(11),
            'workorder_id' => $this->integer(11),
            'description' => $this->text()->notNull(),
            'notes' => $this->text(),
            'price' => $this->money()->notNull(),
            
        ]);
        
        
    }

     /**
     * {@inheritdoc}
     */
    private function labor_down()
    {
        
        $this->dropTable('labor');   
    }

    /**
     * {@inheritdoc}
     */
    public function part_up()
    {
        $this->createTable('part',[
            'id' => $this->primaryKey(11),
            'workorder_id' => $this->integer(11),
            //'price' => $this->decimal(10,2)->notNull(),
            'price' => $this->money()->notNull(),
            'margin' => $this->decimal(10,2)->notNull(),
            'quantity' => $this->decimal(10,2),
            'quantity_type_id' => $this->integer(11),
            'description' => $this->text()->notNull(),
            'part_number' => $this->string(100)->notNull(),
        ]);
        
        
    }

    /**
     * {@inheritdoc}
     */
    private function part_down()
    {
        
        $this->dropTable('part');   
    }

    public function quantity_type_up()
    {
        $this->createTable('quantity_type', [
            'id' => $this->primaryKey(11),
            'description' => $this->text()->notNull(),
        ]);

        $this->batchInsert('quantity_type', 
        [
            'id','description'
        ], 
        [
            [1, 'Gallon'],
            [2, 'Each'],
            [3, 'Quarts']
        ]);
    }

    private function quantity_type_down()
    {
        $this->dropTable('quantity_type');
    }
    
    /**
     * {@inheritdoc}
     */
    private function foreign_key_up()
    {
        $this->addForeignKey('fk_part_workorder', 'part', 'workorder_id', 'workorder', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_labor_workorder', 'labor', 'workorder_id', 'workorder', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_owns_customer', 'owns', 'customer_id', 'customer', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_owns_automobile', 'owns', 'automobile_id', 'automobile', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_address_customer', 'address', 'customer_id', 'customer', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_address_address_type', 'address', 'address_type_id', 'address_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_workorder_customer', 'workorder', 'customer_id', 'customer', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_workorder_automobile', 'workorder', 'automobile_id', 'automobile', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_phone_phone_type', 'phone_number', 'phone_type_id', 'phone_type', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_phone_customer', 'phone_number', 'customer_id', 'customer', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_phone_type_phone', 'phone_type', 'id', 'phone_number', 'phone_type_id', 'CASCADE', 'CASCADE'); //hello
        // $this->addForeignKey('fk_phone_type_customer', 'phone_type', 'customer_id', 'customer', 'id', 'CASCADE', 'CASCADE');
    }

     /**
     * {@inheritdoc}
     */
    private function foreign_key_down()
    {
        $this->dropForeignKey('fk_part_workorder', 'part');
        $this->dropForeignKey('fk_labor_workorder', 'labor');
        $this->dropForeignKey('fk_owns_customer', 'owns');
        $this->dropForeignKey('fk_owns_automobile', 'owns');
        $this->dropForeignKey('fk_address_customer', 'address');
        $this->dropForeignKey('fk_address_address_type', 'address');
        $this->dropForeignKey('fk_workorder_customer', 'workorder');
        $this->dropForeignKey('fk_workorder_automobile', 'workorder');
        $this->dropForeignKey('fk_phone_phone_type', 'phone_number');
        $this->dropForeignKey('fk_phone_customer', 'phone_number');
        $this->dropForeignKey('fk_phone_type_phone', 'phone_type');  

    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->phone_number_up();
        $this->phone_type_up();
        $this->customerUp();
        $this->address_up();
        $this->address_type_up();
        $this->owns_up();
        $this->automobile_up();
        $this->workorder_up();
        $this->labor_up();
        $this->part_up();
        $this->foreign_key_up();
        $this->quantity_type_up();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // echo "m210611_132655_create_tables cannot be reverted.\n";

        // return false;
        $this->foreign_key_down();
        $this->phone_number_down();
        $this->phone_type_down();
        $this->customer_down();
        $this->address_type_down();
        $this->address_down();
        $this->owns_down();
        $this->automobile_down();
        $this->workorder_down();
        $this->labor_down();
        $this->part_down();
        $this->quantity_type_down();

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210611_132655_create_tables cannot be reverted.\n";

        return false;
    }
    */
}
