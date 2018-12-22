<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/22
 * Time: 17:59
 */

namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\GateWay;

class Good extends GateWay
{
    /**
     * jingdong.service.promotion.goodsInfo      获取推广商品信息接口
     * @line http://jos.jd.com/api/detail.htm?apiName=jingdong.service.promotion.goodsInfo&id=1413
     * @param $skuId 多个用逗号
     * @return bool|false|string
     */
    public function Info($skuId)
    {
        if (is_array($skuId)) {
            $skuId = implode(',', $skuId);
        }
        $method = 'jingdong.service.promotion.goodsInfo';
        $specialParameter = [
            'skuIds' => $skuId
        ];
        $goodsJson = $this->send($method, $specialParameter);
        $goodsList = json_decode($goodsJson, true);
        $goodsListDetail = json_decode($goodsList['jingdong_service_promotion_goodsInfo_responce']['getpromotioninfo_result'], true);
        if ($goodsListDetail['sucessed'] == false) {
            return [];
        }
        return $goodsListDetail['result'];
    }
}