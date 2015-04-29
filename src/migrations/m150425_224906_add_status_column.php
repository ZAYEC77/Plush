<?php

use yii\db\Schema;
use yii\db\Migration;

class m150425_224906_add_status_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%order}}', 'status', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('{{%order}}', 'status');
        return true;
    }
}
