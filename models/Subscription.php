<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Subscription extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%subscriptions}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'author_id'], 'required'],
            [['author_id'], 'integer'],
            [['user_id'], 'string', 'max' => 10],
            [['user_id', 'author_id'], 'unique', 'targetAttribute' => ['user_id', 'author_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'author_id' => 'Автор',
            'created_at' => 'Подписан',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public static function isSubscribed($userId, $authorId)
    {
        return self::find()
            ->where(['user_id' => $userId, 'author_id' => $authorId])
            ->exists();
    }

    public static function subscribe($userId, $authorId)
    {
        if (self::isSubscribed($userId, $authorId)) {
            return false;
        }

        $subscription = new self();
        $subscription->user_id = $userId;
        $subscription->author_id = $authorId;
        return $subscription->save();
    }

    public static function unsubscribe($userId, $authorId)
    {
        return self::deleteAll(['user_id' => $userId, 'author_id' => $authorId]);
    }
}