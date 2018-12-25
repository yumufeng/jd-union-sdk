<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 18:39
 */
error_reporting(E_ALL);
require 'vendor/autoload.php';

$config = [
    'appkey' => '947d298f358e40a0ac04b9712a6607cc',
    'appSecret' => 'ab09c191a57c4179915f509736e7e528',
];

$client = new \JdMediaSdk\JdFatory($config);

$result = $client->good->Info(['9615447','3480573']);


var_dump($result);
