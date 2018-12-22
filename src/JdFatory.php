<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 17:41
 */

namespace JdMediaSdk;

use JdMediaSdk\Api\Good;

/**
 * @property Good good
 */
class JdFatory
{

    /**
     * @var null|static 实例对象
     */
    protected static $instance = null;
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
            $classname = __NAMESPACE__."\\Api\\" . ucfirst($api);
            if (!class_exists($classname)) {
                throw new \Exception('api undefined');
                return false;
            }
            $new = new $classname($this->config);
            return $new;
        } catch (\Exception $e) {
            throw new \Exception('api undefined');
        }
    }

}