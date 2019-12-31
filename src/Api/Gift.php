<?php


namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\JdGateWay;

/**
 * Class Gift
 * @package JdMediaSdk\Api
 */
class Gift extends JdGateWay
{
    /**
     * jd.union.open.coupon.gift.get 礼金创建【申请】
     * @param array $param
     * @return bool|string
     * @throws \Exception
     */
    public function get(array $param)
    {
        $params['couponReq'] = $param;
        return $this->send('jd.union.open.coupon.gift.get', $params);
    }

    /**
     * jd.union.open.coupon.gift.stop 礼金停止【申请】
     * @param $giftCouponKey
     * @return bool|string
     * @throws \Exception
     */
    public function stop($giftCouponKey)
    {
        $params = [
            'couponReq' => [
                'giftCouponKey' => $giftCouponKey
            ]
        ];
        return $this->send('jd.union.open.coupon.gift.stop', $params);
    }

    /**
     * jd.union.open.statistics.giftcoupon.query 礼金效果数据
     * @param array $param
     * @return bool|string
     * @throws \Exception
     */
    public function query(array $param)
    {
        $params['couponReq'] = $param;
        return $this->send('jd.union.open.statistics.giftcoupon.query', $params);
    }
}