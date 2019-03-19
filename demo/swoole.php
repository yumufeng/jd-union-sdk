<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/19
 * Time: 10:32
 */

class  swoole
{
    public function __construct()
    {
        $http = new \swoole_http_server("0.0.0.0", 10000);
        $http->set(array(
            'worker_num' => 2,
            'dispatch_mode' => 2,
            'reload_async' => true,
            'max_wait_time' => 50,
            'daemonize' => 0,
            'max_request' => 20000
        ));
        $http->on('Start', [$this, 'onStart']);
        $http->on('WorkerStart', [$this, 'onWorkerStart']);
        $http->on("request", [$this, 'onRequest']);
        $http->on('task', [$this, 'onTask']);
        $http->on('finish', [$this, 'onFinish']);
        $http->start();
    }

    public function onStart(\swoole_server $server)
    {
        echo "swoole is start 0.0.0.0:10000" . PHP_EOL;
    }
}


