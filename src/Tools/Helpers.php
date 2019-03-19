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
 * @param array $header
 * @return bool|string
 * @throws Exception
 */
function curl_get($url, $header = [])
{
    if (!extension_loaded('swoole') || PHP_SAPI != 'cli') {
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
    } else {
        if (version_compare(swoole_version(), '4.0.0', '<')) {
            throw new \Exception('Swoole 扩展版本必须大于4.0.0');
        }
        $urlsInfo = \parse_url($url);
        $queryUrl = $urlsInfo['path'] . '?' . $urlsInfo['query'];
        $domain = $urlsInfo['host'];
        $chan = new Chan(1);
        if ($urlsInfo['scheme'] == 'https') {
            go(function () use ($chan, $domain, $queryUrl, $header) {
                $cli = new Swoole\Coroutine\Http2\Client($domain, 443, true);
                $cli->set([
                    'timeout' => 15,
                    'ssl_host_name' => $domain
                ]);
                $cli->connect();
                $req = new \swoole_http2_request();
                $req->method = 'GET';
                $req->path = $queryUrl;
                $req->headers = $header;
                $cli->send($req);
                $output = $cli->recv();
                $chan->push($output);
                $cli->close();
            });
        } else {
            go(function () use ($chan, $domain, $queryUrl, $header) {
                $cli = new Swoole\Coroutine\Http\Client($domain, 80);
                $cli->setHeaders($header);
                $cli->set(['timeout' => 15]);
                $cli->get($queryUrl);
                $output = $cli->body;
                $chan->push($output);
                $cli->close();
            });
        }
        $output = $chan->pop();
    }
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