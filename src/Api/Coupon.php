<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/22
 * Time: 9:35
 */

namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\JdGateWay;

class Coupon extends JdGateWay
{
    /**
     * @api 优惠券领取情况查询接口【申请】
     * @line https://union.jd.com/openplatform/api/627
     * @param $url
     * @return bool|string
     */
    public function query($url)
    {
        $this->setIsAuth(true);
        if (is_string($url)) {
            $params['couponUrls'] = $url;
        } else {
            $params['couponUrls'] = implode(',', $url);
        }
        return $this->send('queryCoupon', $params);

    }

    /**
     * @api 优惠券导入【申请】
     * @line https://union.jd.com/openplatform/api/696
     * @param $skuId
     * @param string $couponLink
     * @return bool|string
     */
    public function importation($skuId, string $couponLink)
    {
        $params ['couponReq'] = [
            'skuId' => $skuId,
            'couponLink' => $couponLink
        ];

        return $this->send('jd.union.open.coupon.importation', $params);
    }

}