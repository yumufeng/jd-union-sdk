<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 19:03
 */

namespace JdMediaSdk\Tools;


use function JdMediaSdk\curl_get;

class JdGateWay
{
    protected $appkey;
    protected $appSecret;
    protected $access_token;
    const URL = 'https://router.jd.com/api?';

    // 需要access_token
    const NEED_ACCESS_TOKEN = false;
    //联盟的ID
    protected $unionId;
    //推广位ID
    protected $webId;
    protected $error;

    public function __construct(array $config)
    {

        $this->appkey = $config['appkey'];
        $this->appSecret = $config['appSecret'];
    }

    public function setAccessToken(string $accessToken)
    {
        $this->access_token = $accessToken;
    }

    public function getError()
    {
        return $this->error;
    }

    /**
     * 生成签名
     * @param $parameter
     * @return string
     */
    protected function getStringToSign($parameter)
    {
        ksort($parameter);
        $str = '';
        foreach ($parameter as $key => $value) {
            if (!empty($value)) {
                $str .= ($key) . ($value);
            }
        }

        $str = $this->appSecret . $str . $this->appSecret;

        $signature = strtoupper(md5($str));

        return $signature;
    }

    protected function setParameter($method, array $specialParameter)
    {
        $time = date('Y-m-d H:i:s', time());
        $publicParameter = array(
            'access_token' => $this->access_token,
            'app_key' => $this->appkey,
            'format' => 'json',
            'v' => '1.0',
            'timestamp' => $time,
            'method' => $method,
            'sign_method' => 'md5',
            'param_json' => json_encode($specialParameter)
        );
        $sign = $this->getStringToSign($publicParameter);

        $parameter = array_merge($publicParameter, ['sign' => $sign]);
        ksort($parameter);
        $str = '';
        foreach ($parameter as $key => $value) {
            $str .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        return rtrim($str, '&');
    }

    /**
     * 发送参数请求
     * @param $method
     * @param $specialParameter
     * @return bool|string
     */
    protected function send($method, $specialParameter)
    {
        $str = self::setParameter($method, $specialParameter);
        $url = self::URL . $str;
        $result = curl_get($url);
        return $this->parseReps($result);

    }

    /**
     * 解析参数
     * @param $result
     * @return mixed
     */
    private function parseReps($result)
    {
        $decodeObject = json_decode($result, true);
        $nowLists = current($decodeObject);
        if ($nowLists['code'] != 0) {
            $this->error = isset($nowLists['msg']) ? $nowLists['msg'] : '错误信息';
            return false;
        }
        $finally = json_decode($nowLists['result'], true);
        if ($finally['code'] != 200) {
            $this->error = $finally['message'];
            return false;
        }
        return $finally['data'];
    }
}