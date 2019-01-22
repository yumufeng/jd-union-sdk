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
     * @api 关键词商品查询接口【申请】 https://union.jd.com/#/openplatform/api/628
     * @line https://www.coderdoc.cn/jdapiv2?page_id=63
     * @param array $params
     * @return bool|string
     */
    public function query(array $params)
    {
        $this->setIsAuth(true);
        $result = $this->send('queryGoods', $params);
        return $result;
    }

    /**
     * @api 秒杀商品查询接口【申请】
     * @line https://union.jd.com/openplatform/api/667
     * @param array $params
     * @return bool|string
     */
    public function seckill(array $params)
    {
        return $this->send('querySeckillGoods' , $params);
    }

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

    /**
     * @api  商品类目查询
     * @line https://union.jd.com/#/openplatform/api/693
     * @param $parentId
     * @param $grade
     * @return bool|string
     */
    public function category($parentId, $grade)
    {
        $params = [
            'req' => [
                'parentId' => $parentId,
                'grade' => $grade
            ]
        ];
        $result = $this->send('jd.union.open.category.goods.get', $params);
        return $result;
    }
}