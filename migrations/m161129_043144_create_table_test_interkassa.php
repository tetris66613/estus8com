<?php

use yii\db\Migration;

class m161129_043144_create_table_test_interkassa extends Migration
{
    public function up()
    {
        $this->createTable('test_interkassa', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'amount' => $this->float()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('test_interkassa');
    }
}
