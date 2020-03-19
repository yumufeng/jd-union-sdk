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
