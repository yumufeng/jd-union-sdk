<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 17:48
 */

function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);// 要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_HEADER, 0); // 不要http header 加快效率
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}