<?php

use yii\db\Schema;
use yii\db\Migration;

class m150425_212227_add_amount_column extends Migration
{
    public function up()
    {
        $this->addColumn('{{%product}}', 'amount', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('{{%product}}', 'amount');
        return true;
    }
}
