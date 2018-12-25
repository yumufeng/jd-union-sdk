<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/24
 * Time: 9:56
 */

namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\JdGateWay;

class Good extends JdGateWay
{

    /**
     * @api 获取推广商品信息接口
     * @line https://union.jd.com/#/openplatform/api/563
     * @param $skuIds
     * @return bool|string
     */
    public function info($skuIds)
    {
        if (is_array($skuIds)) {
            $skuIds = implode(',', $skuIds);
        }
        $params = [
            'skuIds' => $skuIds
        ];
        $result = $this->send('jd.union.open.goods.promotiongoodsinfo.query', $params);
        return $result;
    }


}