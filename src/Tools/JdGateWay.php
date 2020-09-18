<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 19:03
 */

namespace JdMediaSdk\Tools;

use JdMediaSdk\JdFatory;
use yumufeng\curl\Curl;

class JdGateWay
{
    /**
     * @title 京东联盟官方配置
     * @var mixed
     */
    protected $appkey;
    protected $appSecret;
    protected $siteId;
    protected $unionId;
    protected $positionId;
    protected $pid;

    /**
     * 京佣code
     */
    protected $jyCode;
    /**
     * @api https://apith.cn/dashboard/key 获取地址
     * @var mixed|string
     */
    protected $apithId;
    protected $apithKey;
    /**
     * 是否需要申请权限
     */
    protected $is_auth = false;
    const URL = 'https://router.jd.com/api?';
    const AUTH_URL = 'https://jd.vip.apith.cn/unionv2/';

    /**
     * @var JdFatory
     */
    protected $jdFatory;

    /**
     * 是否强制使用curl，不自动适配swoole协程客户端
     * @var bool
     */
    private $isCurl = false;


    /**
     * JdGateWay constructor.
     * @param array $config
     * @param JdFatory $jdFatory
     */
    public function __construct(array $config, JdFatory $jdFatory)
    {
        $this->appkey = $config['appkey'];
        $this->appSecret = $config['appSecret'];
        $this->apithId = isset($config['apithId']) ? $config['apithId'] : '';
        $this->apithKey = isset($config['apithKey']) ? $config['apithKey'] : '';
        $this->unionId = $config['unionId'];
        $this->positionId = $config['positionId'];
        $this->pid = $config['unionId'] . '_' . $config['siteId'] . '_' . $config['positionId'];
        $this->jdFatory = $jdFatory;
        $this->isCurl = isset($config['isCurl']) && ($config['isCurl'] == true) ? true : false;
        $this->siteId = $config['siteId'];
        $this->jyCode = $config['jyCode'];
    }


    protected function setError($message)
    {
        $this->jdFatory->setError($message);
        return false;
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

    /**
     * jdUnion官方签名
     * @param $method
     * @param array $specialParameter
     * @return string
     */
    protected function setParameter($method, array $specialParameter)
    {
        $time = date('Y-m-d H:i:s', time());
        $publicParameter = array(
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
     * VIp用户签名
     */

    protected function setVipParameter($url)
    {
        $urls = \parse_url($url);
        $dateTime = \gmdate("D, d M Y H:i:s T");
        $SecretId = $this->apithId;
        $SecretKey = $this->apithKey;
        $srcStr = "date: " . $dateTime;
        $Authen = 'hmac id="' . $SecretId . '", algorithm="hmac-sha1", headers="date", signature="';
        $signStr = base64_encode(hash_hmac('sha1', $srcStr, $SecretKey, true));
        $Authen = $Authen . $signStr . "\"";
        // 默认curl的 header
        $headers = [
            'Accept:text/html, */*; q=0.01',
            'Source: ' . $urls['host'],
            'Date: ' . $dateTime,
            'Authorization: ' . $Authen
        ];
        if (PHP_SAPI == 'cli') {
            if (extension_loaded('swoole') && $this->isCurl == false) {
                $headers = [
                    'Accept' => 'text/html, */*; q=0.01',
                    'Source' => $urls['host'],
                    'Date' => $dateTime,
                    'Authorization' => $Authen
                ];
            }
        }
        return $headers;
    }

    /**
     * 发送参数请求
     * @param $method
     * @param $specialParameter
     * @param bool $raw
     * @return bool|string
     * @throws \Exception
     */
    protected function send($method, array $specialParameter, $raw = false)
    {
        $header = [];
        if ($this->is_auth === true) {
            $url = self::AUTH_URL . $method . '?' . http_build_query($specialParameter);
            $header = self::setVipParameter($url);
        } else {
            $str = self::setParameter($method, $specialParameter);
            $url = self::URL . $str;
        }
        $result = $this->isCurl == true ? Curl::fpm_curl_get($url, $header) : Curl::curl_get($url, $header);
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
        if (is_string($decodeObject)) {
            return $this->setError($decodeObject);
        }
        if (is_null($decodeObject)) {
            return $this->setError("Api返回结果为空");
        }
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
                $msg = '错误信息';
                isset($nowLists['msg']) && $msg = $nowLists['msg'];
                isset($nowLists['zh_desc']) && $msg = $nowLists['zh_desc'];
                return $this->setError($msg);
            }
            $finally = json_decode($nowLists['result'], true);
            if ($finally['code'] != 200) {
                return $this->setError($finally['message']);
            }
            if ($raw == true) {
                return $finally;
            }
            return isset($finally['data']) ? $finally['data'] : [];
        }
    }
}