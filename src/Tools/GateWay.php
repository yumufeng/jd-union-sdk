<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 19:03
 */

namespace JdMediaSdk;


class GateWay
{
    protected $appkey;
    protected $appSecret;
    protected $access_token;
    const URL = 'https://api.jd.com/routerjson?';
    //联盟的ID
    protected $unionId;
    //推广位ID
    protected $webId;
    private $ua = 'pc';

    public function __construct($config)
    {
        $this->appkey = $config['appkey'];
        $this->appSecret = $config['appSecret'];
        $this->access_token = $config['access_token'];
        $this->webId = isset($config['webId']) ? $config['webId'] : '1479909014';
        $this->unionId = isset($config['unionId']) ? $config['unionId'] : '1000586580';
    }

    /**
     * 设置联盟ID
     * @param $webId
     * @param $unionId
     * @return $this
     */
    public function setUnionId($webId, $unionId)
    {
        $this->webId = $webId;
        $this->unionId = $unionId;
        return $this;
    }

    /**
     * 设置类型，pc或者
     * @param string $ua pc或者wl
     * @return GateWay
     */
    public function setUaChannel($ua = 'wl')
    {
        $this->ua = $ua;
        return $this;
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
            $str .= urlencode($key) . urlencode($value);
        }

        $str = $this->appSecret . $str . $this->appSecret;

        $signature = strtoupper(md5($str));

        return $signature;
    }

    protected function setParameter($method, array $specialParameter)
    {
        $time = date('Y-m-d H:i:s', time());
        $parameter = array_merge([
            'channel' => $this->ua,
            'unionId' => $this->unionId,
            'webId' => $this->webId,
        ], $specialParameter);
        $publicParameter = array(
            'access_token' => $this->access_token,
            'app_key' => $this->appkey,
            'v' => '2.0',
            'timestamp' => $time,
            'method' => $method,
            '360buy_param_json' => json_encode($parameter)
        );
        $sign = $this->getStringToSign($publicParameter);

        $parameter = array_merge($publicParameter, ['sign' => $sign]);
        ksort($parameter);
        $str = '';
        foreach ($parameter as $key => $value) {
            $str .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        return $str;
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
        return curl_get($url);
    }
}