<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author}}`.
 */
class m260426_190448_create_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'img' => $this->string(255),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('author');
    }
}
