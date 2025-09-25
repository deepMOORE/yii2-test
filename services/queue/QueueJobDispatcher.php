<?php declare(strict_types=1);

namespace app\services\queue;

use app\services\queue\jobs\BaseQueueJob;
use Yii;

final class QueueJobDispatcher
{
    public static function dispatch(BaseQueueJob $job): void
    {
        Yii::$app->queue->push($job);
    }
}