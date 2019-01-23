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
    public function get($param)
    {
        $params = [];
        if (is_string($param)) {
            $params['materialId'] = $param;
        } else {
            $params = $param;
        }
        if (!isset($params['siteId'])) {
            $params['siteId'] = $this->siteId;
        }
        if (!isset($params['positionId'])) {
            $params['positionId'] = $this->positionId;
        }
        $reqParams = [
            'promotionCodeReq' => $params,
        ];
        $result = $this->send('jd.union.open.promotion.common.get', $reqParams);
        return $result;
    }

    /**
     * @api 通过unionId获取推广链接【申请】
     * @line https://union.jd.com/openplatform/api/631
     * @param $url
     * @param string $conponUrl
     * @return bool|string
     */
    public function byUnionId($url, $conponUrl = '')
    {
        $this->setIsAuth(true);
        if (!isset($params['unionId'])) {
            $params['unionId'] = $this->unionId;
        }
        if (!isset($params['positionId'])) {
            $params['positionId'] = $this->positionId;
        }

        $params['materialId'] = $url;

        if (!empty($conponUrl)) {
            $params['couponUrl'] = $conponUrl;
        }
        return $this->send('getByUnionidPromotion', $params);

    }

}