<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_authors}}`.
 */
class m260426_190535_create_book_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('book_authors', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk-book_authors-book_id', 'book_authors', 'book_id', 'book', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-book_authors-author_id', 'book_authors', 'author_id', 'author', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('fk-book_authors-author_id', 'book_authors');
        $this->dropForeignKey('fk-book_authors-book_id', 'book_authors');
        $this->dropTable('book_authors');
    }
}
