<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m260426_190507_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'year' => $this->integer()->notNull(),
            'isbn' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'img' => $this->string(255),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('book');
    }
}
