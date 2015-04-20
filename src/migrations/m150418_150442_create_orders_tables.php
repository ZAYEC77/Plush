<?php

use yii\db\Schema;
use yii\db\Migration;

class m150418_150442_create_orders_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order}}', [
            'id' => Schema::TYPE_PK,
            'price' => Schema::TYPE_DECIMAL,
            'userId' => Schema::TYPE_INTEGER,
            'description' => Schema::TYPE_TEXT,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%order_item}}', [
            'id' => Schema::TYPE_PK,
            'amount' => Schema::TYPE_INTEGER,
            'orderId' => Schema::TYPE_INTEGER,
            'productId' => Schema::TYPE_INTEGER . ' NOT NULL',
            'price' => Schema::TYPE_DECIMAL,
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%order_item}}');
        return true;
    }
}
