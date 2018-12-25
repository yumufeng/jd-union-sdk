<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/25
 * Time: 18:00
 */

namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\JdGateWay;

class Link extends JdGateWay
{

    /**
     * @api 获取通用推广链接
     * @line https://union.jd.com/#/openplatform/api/691
     * @param array $params
     * @return bool|string
     */
    public function get(array $params)
    {
        $reqParams = [
            'promotionCodeReq' => $params,
        ];
        $result = $this->send('jd.union.open.promotion.common.get', $reqParams);
        return $result;
    }

}