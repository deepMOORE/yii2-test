<?php

use yii\db\Connection;

$host = 'localhost';
$database = 'yii2basic';
$port = 3306;
$user = 'root';
$password = 'root';

return [
    'class' => Connection::class,
    'dsn' => "mysql:host=$host;dbname=$database",
    'username' => $user,
    'password' => $password,
    'charset' => 'utf8',
];
