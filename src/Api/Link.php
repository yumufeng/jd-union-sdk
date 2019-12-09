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
     * @param $url 可以是优惠券或普通产品链接
     * @param array $params 扩展参数
     * @return bool|string
     * @throws \Exception
     */
    public function get($url, array $params = [])
    {
        if (!isset($params['siteId'])) {
            $params['siteId'] = $this->siteId;
        }
        if (!isset($params['positionId']) && !empty($this->positionId)) {
            $params['positionId'] = $this->positionId;
        }
        $params['materialId'] = $url;

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
     * @param array $params 传入配置参数
     * @return bool|string
     * @throws \Exception
     */
    public function byUnionId($url, $conponUrl = '', $params = [])
    {
        if (!isset($params['unionId'])) {
            $params['unionId'] = $this->unionId;
        }
        if (!isset($params['positionId']) && !empty($this->positionId)) {
            $params['positionId'] = $this->positionId;
        }
        if (!empty($conponUrl)) {
            $params['couponUrl'] = $conponUrl;
        }
        $params['materialId'] = $url;

        $reqParams = [
            'promotionCodeReq' => $params,
        ];
        return $this->send('jd.union.open.promotion.byunionid.get', $reqParams);
    }

}
