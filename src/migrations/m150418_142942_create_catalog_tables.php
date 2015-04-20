<?php

use yii\db\Schema;
use yii\db\Migration;

class m150418_142942_create_catalog_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'image' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
            'vendorId' => Schema::TYPE_INTEGER,
            'price' => Schema::TYPE_DECIMAL,
            'status' => Schema::TYPE_INTEGER,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%vendor}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'image' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%category}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING,
            'image' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT,
            'parentId' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%product_has_category}}', [
            'productId' => Schema::TYPE_INTEGER . ' NOT NULL',
            'categoryId' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%products}}');
        $this->dropTable('{{%vendor}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%product_has_category}}');
        return true;
    }
}
