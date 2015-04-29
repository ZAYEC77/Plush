<?php

use yii\db\Schema;
use yii\db\Migration;

class m150425_221538_add_contacts_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%order}}', 'contacts', Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->dropColumn('{{%order}}', 'contacts');
        return true;
    }
}
