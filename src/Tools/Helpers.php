<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 17:48
 */

namespace JdMediaSdk\Tools;

class Helpers
{
    /**
     * @param $url
     * @param array $header
     * @return bool|string
     * @api 共用发送get请求
     */
    public static function curl_get($url, $header = [])
    {
        if (!extension_loaded('swoole')) {
            $output = self::fpm_curl_get($url, $header);
        } else {
            if (PHP_SAPI == 'cli') {
                $urlsInfo = \parse_url($url);
                $queryUrl = $urlsInfo['path'];
                if (isset($urlsInfo['query'])) {
                    $queryUrl .= '?' . $urlsInfo['query'];
                }
                $domain = $urlsInfo['host'];
                if (isset($urlsInfo['port'])) {
                    $port = $urlsInfo['port'];
                } else {
                    $port = ($urlsInfo['scheme'] == 'https' ? 443 : 80);
                }
                $chan = new \Swoole\Coroutine\Channel(1);
                go(function () use ($chan, $domain, $queryUrl, $header, $port) {
                    $cli = new \Swoole\Coroutine\Http\Client($domain, $port, $port == 443 ? true : false);
                    $cli->setHeaders($header);
                    $cli->set(['timeout' => 15]);
                    $cli->get($queryUrl);
                    $output = $cli->body;
                    $chan->push($output);
                    $cli->close();
                });
                $output = $chan->pop();
            } else {
                $output = self::fpm_curl_get($url, $header);
            }
        }
        return $output;
    }


    /**
     * fpm模式
     * @param $url
     * @param array $header
     * @return bool|string
     */
    public static function fpm_curl_get($url, $header = [])
    {
        $ch = \curl_init();
        \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        // https请求 不验证证书和hosts
        \curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        \curl_setopt($ch, CURLOPT_URL, $url);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 要求结果为字符串且输出到屏幕上
        if (!empty($header)) {
            \curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        } else {
            \curl_setopt($ch, CURLOPT_HEADER, 0); // 不要http header 加快效率
        }
        \curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public static function curl_get_302($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
        $data = curl_exec($ch);
        $Headers = curl_getinfo($ch);
        curl_close($ch);
        if ($data != $Headers)
            return $Headers["url"];
        else
            return false;
    }
}
