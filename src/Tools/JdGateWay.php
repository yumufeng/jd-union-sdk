<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 19:03
 */

namespace JdMediaSdk\Tools;

use JdMediaSdk\JdFatory;

class JdGateWay
{
    protected $appkey;
    protected $appSecret;
    protected $siteId;
    protected $unionId;
    protected $positionId;
    protected $pid;
    /**
     * 是否需要申请权限
     */
    protected $is_auth = false;

    protected $access_token;
    // 需要access_token
    const NEED_ACCESS_TOKEN = false;
    const URL = 'https://router.jd.com/api?';
    const AUTH_URL = 'https://jd.open.apith.cn/unionv2/';

    /**
     * @var JdFatory
     */
    protected $jdFatory;

    public function __construct(array $config, JdFatory $jdFatory)
    {

        $this->appkey = $config['appkey'];
        $this->appSecret = $config['appSecret'];
        $this->siteId = $config['siteId'];
        $this->unionId = $config['unionId'];
        $this->positionId = $config['positionId'];
        $this->pid = $config['unionId'] . '_' . $config['siteId'] . '_' . $config['positionId'];
        $this->jdFatory = $jdFatory;
    }

    public function setAccessToken(string $accessToken)
    {
        $this->access_token = $accessToken;
    }

    /**
     * 是否需要申请权限
     * @param  $is_auth
     */
    protected function setIsAuth($is_auth)
    {
        $this->is_auth = $is_auth;
    }

    protected function setError($message)
    {
        return $this->jdFatory->setError($message);
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
     * @param bool $raw
     * @return bool|string
     */
    protected function send($method, array $specialParameter, $raw = false)
    {
        if ($this->is_auth === true) {
            $url = self::AUTH_URL . $method . '?' . http_build_query($specialParameter);
        } else {
            $str = self::setParameter($method, $specialParameter);
            $url = self::URL . $str;
        }
        $result = curl_get($url);
        return $this->parseReps($result, $raw);

    }

    /**
     * 解析参数
     * @param $result
     * @param bool $raw
     * @return mixed
     */
    private function parseReps($result, $raw = false)
    {
        $decodeObject = json_decode($result, true);
        if ($this->is_auth === true) {
            if ($raw == true) {
                return $decodeObject;
            }
            if ($decodeObject['code'] != 1) {
                $this->setError($decodeObject['msg']);
                return false;
            }
            return isset($decodeObject['data']) ? $decodeObject['data'] : [];
        } else {
            $nowLists = current($decodeObject);
            if ($nowLists['code'] != 0) {
                $this->setError(isset($nowLists['msg']) ? $nowLists['msg'] : '错误信息');
                return false;
            }
            $finally = json_decode($nowLists['result'], true);
            if ($finally['code'] != 200) {
                $this->setError($finally['message']);
                return false;
            }
            if ($raw == true) {
                return $finally;
            }
            return isset($finally['data']) ? $finally['data'] : [];
        }
    }
}