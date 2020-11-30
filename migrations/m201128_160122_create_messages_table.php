<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m201128_160122_create_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'deleted_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);

        $this->createIndex(
            'idx-messages-author_id',
            'messages',
            'author_id'
        );

        $this->addForeignKey(
            'fk-messages-author_id',
            'messages',
            'author_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
         $this->dropForeignKey(
            'fk-messages-author_id',
            'messages'
        );

        
        $this->dropIndex(
            'idx-messages-author_id',
            'messages'
        );

        $this->dropTable('{{%post}}');

    }
}
