<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m260426_190604_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        $this->createTable('subscription', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'number' => $this->string(255)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('subscription');
    }
}
