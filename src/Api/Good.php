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
        if (!isset($params['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
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
        $this->setIsAuth(true);
        return $this->send('querySeckillGoods', $params);
    }

    /**
     * @api 学生价商品查询接口【申请】
     * @link https://union.jd.com/openplatform/api/666
     * @param array $param
     * @return bool|string
     */
    public function stuprice(array $param)
    {
        //TODO
        if (!isset($param['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
        $params = [
            'goodsReq' => $param
        ];

        return $this->send('jd.union.open.goods.stuprice.query', $params);
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
     * @api 获取详情的图片集合
     * @param $skuId
     * @param bool $raw
     * @return |null |null array
     */
    public function detail($skuId, $raw = false)
    {
        $urls = "https://cd.jd.com/description/channel?skuId={$skuId}&mainSkuId={$skuId}";

        $content = curl_get($urls);
        $content = json_decode($content, true);
        if ($raw == true) {
            return $content['content'];
        }
        return get_images_from_html($content['content']);
    }

    /**
     * @api  商品类目查询
     * @line https://union.jd.com/#/openplatform/api/693
     * @param $parentId
     * @param $grade
     * @return bool|string
     */
    public function category($parentId = 0, $grade = 0)
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

    /**
     * @api 京粉精选商品查询接口
     * @line https://union.jd.com/openplatform/api/739
     * @param int $eliteId
     * 频道id：1-好券商品；
     *        2-京粉APP.大咖推荐；
     *        3-小程序-好券商品；
     *        4-京粉APP-.主题街.服装运动；
     *        5-京粉APP-主题街.精选家电；
     *        6-京粉APP-主题街.超市；
     *        7-京粉APP-主题街.居家生活；
     *        10-9.9专区；
     *        11-品牌好货.潮流范儿；
     *        12-品牌好货.精致生活；
     *        13-品牌好货.数码先锋；
     *        14-品牌好货.品质家电；
     *        15-京仓配送；
     *        16-公众号.好券商品；
     *        17-公众号.9.9；
     *        18-公众号-京仓京配
     * @param int $pageIndex 页码
     * @param int $pageSize 每页数量, 最大50
     * @param string $sortName 排序字段(price：单价, commissionShare：佣金比例, commission：佣金， inOrderCount30DaysSku：sku维度30天引单量，comments：评论数，goodComments：好评数
     * @param string $sort 默认降序  asc,desc升降序
     * @return bool|string
     */
    public function jingfen($eliteId = 1, $pageIndex = 1, $pageSize = 50, $sortName = 'price', $sort = 'desc')
    {

        $params = [
            'goodsReq' => [
                'eliteId' => $eliteId,
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'sortName' => $sortName,
                'sort' => $sort
            ]
        ];

        $result = $this->send('jd.union.open.goods.jingfen.query', $params, true);

        return $result;
    }
}