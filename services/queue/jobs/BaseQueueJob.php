<?php declare(strict_types=1);

namespace app\services\queue\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;

abstract class BaseQueueJob extends BaseObject implements JobInterface
{
    //
}