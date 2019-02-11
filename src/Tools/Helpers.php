<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 17:48
 */

/**
 * @api 发送get请求
 * @param $url
 * @return bool|string
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

/**
 * @api 发送get请求
 * @param $content
 * @return null
 *  从HTML文本中提取所有图片
 */
function get_images_from_html($content)
{
    $pattern = "/<img.*?data-lazyload=[\'|\"](.*?)[\'|\"].*?[\/]?>/";
    preg_match_all($pattern, $content, $match);
    if (!empty($match[1])) {
        return $match[1];
    }
    return null;
}

/**
 * 从css中获取图片
 * @param $content
 * @return |null
 */
function get_images_from_css($content)
{
    preg_match_all("/background-image:url\((.*)\)/", $content, $match);
    if (!empty($match[1])) {
        return $match[1];
    }
    return null;
}