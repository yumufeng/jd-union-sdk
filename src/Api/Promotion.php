<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/25
 * Time: 10:02
 */

namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\JdGateWay;

class Promotion extends JdGateWay
{
    /**
     * @api 订单查询接口
     * @line https://union.jd.com/#/openplatform/api/650
     * @param array $params
     * @return bool|string
     */

    public function order(array $params)
    {
        $reqParams = [
            'orderReq' => $params,
        ];
        $result = $this->send('jd.union.open.order.query', $reqParams, true);
        return $result;
    }


    /**
     * @api 获取PID
     * @line https://union.jd.com/#/openplatform/api/646
     * @param array $params
     * @return bool|string
     */
    public function pid(array $params)
    {
        $reqParams = [
            'pidReq' => $params,
        ];
        $result = $this->send('jd.union.open.user.pid.get', $reqParams);
        return $result;
    }
}