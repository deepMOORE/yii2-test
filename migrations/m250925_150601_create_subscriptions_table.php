<?php

use yii\db\Migration;

class m250925_150601_create_subscriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->string(10)->notNull(),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-subscriptions-user_id-author_id',
            '{{%subscriptions}}',
            ['user_id', 'author_id'],
            true
        );

        $this->createIndex(
            'idx-subscriptions-user_id',
            '{{%subscriptions}}',
            'user_id'
        );

        $this->createIndex(
            'idx-subscriptions-author_id',
            '{{%subscriptions}}',
            'author_id'
        );

        $this->addForeignKey(
            'fk-subscriptions-author_id',
            '{{%subscriptions}}',
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
            'fk-subscriptions-author_id',
            '{{%subscriptions}}'
        );

        $this->dropIndex(
            'idx-subscriptions-author_id',
            '{{%subscriptions}}'
        );

        $this->dropIndex(
            'idx-subscriptions-user_id',
            '{{%subscriptions}}'
        );

        $this->dropIndex(
            'idx-subscriptions-user_id-author_id',
            '{{%subscriptions}}'
        );

        $this->dropTable('{{%subscriptions}}');
    }
}