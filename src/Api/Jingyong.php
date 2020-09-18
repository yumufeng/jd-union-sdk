<?php


namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\JdGateWay;
use yumufeng\curl\Curl;

class Jingyong extends JdGateWay
{
    private $jyurl = 'https://draw.jdfcloud.com';

    /**
     * 关键词商品搜索
     * @param array $param
     * @return bool|string
     */
    public function queryGood(array $param)
    {

        if (!isset($param['pageNo'])) {
            $param['pageNo'] = 1;
        }
        if (!isset($param['pageSize'])) {
            $param['pageSize'] = 20;
        }
        return $this->post('/out/cps/queryGoods', $param);
    }

    /**
     * 订单同步
     * @param array $param
     * @return bool|string
     */
    public function order(array $param)
    {
        if (!isset($param['startTime'])) {
            $this->jdFatory->setError("startTime 不能为空");
            return false;
        }
        if (!isset($param['endTime'])) {
            $this->jdFatory->setError("endTime 不能为空");
            return false;
        }
        if (!isset($param['itemsPerPage'])) {
            $param['itemsPerPage'] = 50;
        }
        if (!isset($param['curPage'])) {
            $param['curPage'] = 1;
        }
        if (!isset($param['type'])) {
            $param['type'] = 1;
        }
        return $this->post('/out/cps/queryOrder', $param);
    }

    /**
     * 转链接口
     * @param $skuLink
     * @param $couponUrl
     * @param string $subUnionId
     * @return bool|string
     */
    public function convert($skuLink, $couponUrl = '', $subUnionId = '')
    {
        $params = [
            'materialId' => $skuLink
        ];
        if (!empty($couponUrl)) {
            $params['couponUrl'] = $couponUrl;
            $params['subUnionId'] = $subUnionId;
        }
        return $this->post('/out/cps/getUrl', $params);
    }


    protected function post($method, $param)
    {
        $url = $this->jyurl + $method;
        $param['code'] = $this->jyCode;
        $data = \json_encode($param);
        return Curl::curl_post($url, $data);
    }
}