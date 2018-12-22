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
    'appkey' => 'FE7435346046BCF7A1143D8CC5633980',
    'appSecret' => '0338be21a31b465ebbd053fed43837db',
    'access_token' => '267709ee-c9c9-4c82-90c4-c813a8977c82',
    'webId' => '1479909014',
    'unionId' => '1000586580',
];

$client = new \JdMediaSdk\JdFatory($config);

$result = $client->good->Info(['965447','3480573']);
