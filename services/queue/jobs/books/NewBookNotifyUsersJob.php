<?php declare(strict_types=1);

namespace app\services\queue\jobs\books;

use app\services\queue\jobs\BaseQueueJob;
use app\services\queue\QueueJobDispatcher;
use Yii;
use yii\db\Query;

class NewBookNotifyUsersJob extends BaseQueueJob
{
    public int $authorId;
    public $book;

    private const BATCH_SIZE = 100;

    public function execute($queue)
    {
        $db = Yii::$app->db;

        $count = (new Query())
            ->from('{{%subscriptions}}')
            ->where(['author_id' => $this->authorId])
            ->count($db);

        if ($count == 0) {
            return;
        }

        $offset = 0;
        while ($offset < $count) {
            $userIds = (new Query())
                ->select('user_id')
                ->from('{{%subscriptions}}')
                ->where(['author_id' => $this->authorId])
                ->orderBy('id')
                ->limit(self::BATCH_SIZE)
                ->offset($offset)
                ->column($db);

            if (empty($userIds)) {
                break;
            }

            QueueJobDispatcher::dispatch(new NewBookNotifyUsersBatchJob([
                'book' => $this->book,
                'userIds' => $userIds,
            ]));

            $offset += count($userIds);
        }
    }
}