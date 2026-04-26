<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m260426_185130_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
