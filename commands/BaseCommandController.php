<?php declare(strict_types=1);

namespace app\commands;

use yii\console\Controller;

abstract class BaseCommandController extends Controller
{
    protected function log(string $message): void
    {
        echo '[' . static::class . '] ' . $message . PHP_EOL;
    }
}
