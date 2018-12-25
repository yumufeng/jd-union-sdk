<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 17:41
 */

namespace JdMediaSdk;

use JdMediaSdk\Api\Good;
use JdMediaSdk\Api\Promotion;

/**
 * @property Good good  查询商品API
 * @property Promotion promotion  PID&推广位API
 */
class JdFatory
{
    private $config;

    public function __construct($config = null)
    {
        if (empty($config)) {
            throw new \Exception('no config');
        }
        $this->config = $config;
        return $this;
    }

    public function __get($api)
    {
        try {
            $classname = __NAMESPACE__ . "\\Api\\" . ucfirst($api);
            if (!class_exists($classname)) {
                throw new \Exception('api undefined');
                return false;
            }
            $new = new $classname($this->config);
            if ($new::NEED_ACCESS_TOKEN == true) {
                $new->setAccessToken($this->getAccessToken());
            }
            return $new;
        } catch (\Exception $e) {
            throw new \Exception('api undefined');
        }
    }

    /**
     * 获取accessToken
     */
    private function getAccessToken()
    {

    }

}