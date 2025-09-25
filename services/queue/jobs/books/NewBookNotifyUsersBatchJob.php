<?php declare(strict_types=1);

namespace app\services\queue\jobs\books;

use app\services\queue\jobs\BaseQueueJob;
use app\services\queue\jobs\notifications\SendNotificationJob;
use app\services\queue\QueueJobDispatcher;

class NewBookNotifyUsersBatchJob extends BaseQueueJob
{
    public $book;
    /** @var array<int|string> */
    public array $userIds = [];

    public function execute($queue)
    {
        if (count($this->userIds) < 1) {
            return;
        }

        foreach ($this->userIds as $userId) {
            $job = new SendNotificationJob([
                'toUserId' => $userId,
                'content' => [
                    'book' => $this->book,
                ],
            ]);

            QueueJobDispatcher::dispatch($job);
        }
    }
}