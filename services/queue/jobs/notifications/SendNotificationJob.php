<?php declare(strict_types=1);

namespace app\services\queue\jobs\notifications;

use app\services\queue\jobs\BaseQueueJob;

class SendNotificationJob extends BaseQueueJob
{
    public int $toUserId;
    public object $content;

    public function execute($queue)
    {
        // send notifications to channels of $this->toUserId
    }
}