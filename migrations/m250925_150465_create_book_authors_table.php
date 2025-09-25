<?php

use yii\db\Migration;

class m250925_150465_create_book_authors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_authors}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-book_authors-book_id-author_id',
            '{{%book_authors}}',
            ['book_id', 'author_id'],
            true
        );

        $this->createIndex(
            'idx-book_authors-book_id',
            '{{%book_authors}}',
            'book_id'
        );

        $this->createIndex(
            'idx-book_authors-author_id',
            '{{%book_authors}}',
            'author_id'
        );

        $this->addForeignKey(
            'fk-book_authors-book_id',
            '{{%book_authors}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-book_authors-author_id',
            '{{%book_authors}}',
            'author_id',
            '{{%authors}}',
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
            'fk-book_authors-author_id',
            '{{%book_authors}}'
        );

        $this->dropForeignKey(
            'fk-book_authors-book_id',
            '{{%book_authors}}'
        );

        $this->dropIndex(
            'idx-book_authors-author_id',
            '{{%book_authors}}'
        );

        $this->dropIndex(
            'idx-book_authors-book_id',
            '{{%book_authors}}'
        );

        $this->dropIndex(
            'idx-book_authors-book_id-author_id',
            '{{%book_authors}}'
        );

        $this->dropTable('{{%book_authors}}');
    }
}