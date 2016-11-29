<?php

use yii\db\Migration;

class m161128_203855_create_table_users extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string(254)->notNull(),
            'password_hash' => $this->text()->notNull(),
            'auth_key' => $this->text()->notNull(),
            'role' => $this->smallInteger()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'created' => $this->timestamp()->notNull(),
            'updated' => $this->timestamp()->null(),
            'password_reset_token' => $this->text()->null(),
            'username' => $this->string(16)->null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
