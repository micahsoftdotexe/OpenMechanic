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
        $this->createTable('customer', [
            'id' => $this->primaryKey(11),
            'first_name' => $this->string(50),
            'last_name' => $this->string(50),
            'street_address' => $this->string(256),
            'city' => $this->string(128),
            'zip' => $this->string(5),
            'state' => $this->string(2),
            'phone_number_1' => $this->string(15),
            'phone_number_2' => $this->string(15),
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
        $this->createTable('phone_number', [
            // 'customer_id' => $this->primaryKey(11),
            // 'phone_type_id' => $this->primaryKey(),
            'id' => $this->primaryKey(11),
            'customer_id' => $this->integer(11)->notNull(),
            'phone_type_id' => $this->integer(11),
            'phone_number' => $this->string(15)->notNull(),
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
        $this->createTable('phone_type', [
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
    private function order_up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(11),
            'customer_id' => $this->integer(11)->notNull(),
            'automobile_id' => $this->integer(11)->notNull(),
            'odometer_reading' => $this->integer(25)->notNull(),
            'stage' => $this->integer(11)->notNull(),
            'date' => $this->datetime(),
            //'subtotal' => $this->decimal(10, 2),
            'tax' => $this->decimal(10, 2),
            //'notes' => $this->text(),
            'amount_paid' => $this->decimal(10, 2),
            'paid_in_full' => $this->boolean(),
        ]);
    }
    private function notes_up()
    {
        $this->createTable('note', [
            'id' => $this->primaryKey(11),
            'order_id' => $this->integer(11)->notNull(),
            'created_by' => $this->integer(11)->notNull(),
            'text' => $this->text(),
        ]);
    }

    private function notes_down()
    {
        $this->dropTable('note');
    }

    private function order_down(){

        // $this->addForeignKey('fk_order_automobile', 'order');
        $this->dropTable('order');
    }

    /**
     * {@inheritdoc}
     */
    public function address_up(){
        $this->createTable('address', [
            'id' => $this->primaryKey(11),
            'customer_id' => $this->integer(11)->notNull(),
            'street_address_1' => $this->string(250)->notNull(),
            'city' => $this->string(100)->notNull(),
            'zip' => $this->string(5)->notNull(),
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
        $this->createTable('address_type', [
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
        $this->createTable('owns', [
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
        $this->createTable('automobile', [
            'id' => $this->primaryKey(11),
            'vin' => $this->string(17)->notNull(),
            'make' => $this->string(128)->notNull(),
            'model' => $this->string(128)->notNull(),
            'year' => $this->string(20)->notNull(),
            'motor_number' => $this->decimal(10, 2)->notNull()
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
        $this->createTable('labor', [
            'id' => $this->primaryKey(11),
            'order_id' => $this->integer(11),
            'description' => $this->text()->notNull(),
            'notes' => $this->text(),
            'price' => $this->decimal(10, 2)->notNull(),
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
        $this->createTable('part', [
            'id' => $this->primaryKey(11),
            'order_id' => $this->integer(11),
            'price' => $this->decimal(10, 2)->notNull(),
            'margin' => $this->decimal(10, 2)->notNull(),
            'quantity' => $this->decimal(10, 2),
            'quantity_type_id' => $this->integer(11),
            'description' => $this->text()->notNull(),
            'part_number' => $this->string(100)->notNull(),
        ]);
    }

    public function user_up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'first_name' => $this->string(50)->notNull(),
            'last_name' => $this->string(50)->notNull(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull(),
        ]);
        $this->batchInsert('user', ['first_name', 'last_name', 'username', 'password', 'auth_key', 'status'], [
            ['admin', 'admin', 'admin', Yii::$app->security->generatePasswordHash('admin'), 'admin', 1],
        ]);
    }

    public function user_down()
    {
        $this->dropTable('user');
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
        $this->addForeignKey('fk_part_order', 'part', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_note_order', 'note', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_note_user', 'note', 'created_by', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_labor_order', 'labor', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_owns_customer', 'owns', 'customer_id', 'customer', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_owns_automobile', 'owns', 'automobile_id', 'automobile', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_customer', 'order', 'customer_id', 'customer', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_part_quantity_type', 'part', 'quantity_type_id', 'quantity_type', 'id', 'NO ACTION', 'CASCADE');
        $this->addForeignKey('fk_order_automobile', 'order', 'automobile_id', 'automobile', 'id', 'CASCADE', 'CASCADE');
    }

     /**
     * {@inheritdoc}
     */
    private function foreign_key_down()
    {
        $this->dropForeignKey('fk_part_order', 'part', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey('fk_note_order', 'note', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey('fk_note_user', 'note', 'created_by', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey('fk_labor_order', 'labor', 'order_id', 'order', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey('fk_owns_customer', 'owns', 'customer_id', 'customer', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey('fk_owns_automobile', 'owns', 'automobile_id', 'automobile', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey('fk_order_customer', 'order', 'customer_id', 'customer', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey('fk_order_automobile', 'order', 'automobile_id', 'automobile', 'id', 'CASCADE', 'CASCADE');
        $this->dropForeignKey('fk_part_quantity_type', 'part', 'quantity_type_id', 'quantity_type', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$this->phone_number_up();
        //$this->phone_type_up();
        $this->user_up();
        $this->customerUp();
        //$this->address_up();
        //$this->address_type_up();
        $this->owns_up();
        $this->automobile_up();
        $this->order_up();
        $this->notes_up();
        $this->labor_up();
        $this->part_up();
        //$this->stage_up();
        $this->quantity_type_up();
        $this->foreign_key_up();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // echo "m210611_132655_create_tables cannot be reverted.\n";

        // return false;
        $this->foreign_key_down();
        $this->user_down();
        $this->customer_down();
        $this->owns_down();
        $this->automobile_down();
        $this->notes_down();
        $this->order_down();
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
