<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/24
 * Time: 9:56
 */

namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\Helpers;
use JdMediaSdk\Tools\JdGateWay;

class Good extends JdGateWay
{
    /**
     * @param array $params
     * @param bool $raw
     * @return bool|string
     * @throws \Exception
     * @api 关键词商品查询接口【申请】
     * @line https://union.jd.com/#/openplatform/api/628
     */

    public function query(array $params, $raw = false)
    {
        if (!isset($params['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
        $sends = [
            'goodsReqDTO' => $params
        ];
        $result = $this->send('jd.union.open.goods.query', $sends, $raw);
        return $result;
    }

    /**
     * @param array $param
     * @return bool|string
     * @throws \Exception
     * @link https://union.jd.com/openplatform/api/666
     * @api 学生价商品查询接口【申请】
     */
    public function stuprice(array $param, $raw = false)
    {
        //TODO
        if (!isset($param['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
        $params = [
            'goodsReq' => $param
        ];

        return $this->send('jd.union.open.goods.stuprice.query', $params, $raw);
    }

    /**
     * @param array $params
     * @return bool|string
     * @throws \Exception
     * @api 秒杀商品查询接口【申请】
     * @line https://union.jd.com/openplatform/api/667
     */
    public function seckill(array $params, $raw = false)
    {
        $params = [
            'goodsReq' => $params
        ];
        return $this->send('jd.union.open.goods.seckill.query', $params, $raw);
    }

    /**
     * @param $skuIds
     * @return bool|string
     * @throws \Exception
     * @api 获取推广商品信息接口
     * @line https://union.jd.com/#/openplatform/api/563
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
     * @param $parentId
     * @param $grade
     * @return bool|string
     * @throws \Exception
     * @api  商品类目查询
     * @line https://union.jd.com/#/openplatform/api/693
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
     * @throws \Exception
     * @api 京粉精选商品查询接口
     * @line https://union.jd.com/openplatform/api/739
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

    /**
     * 大字段商品查询接口（内测版）【申请】
     * jd.union.open.goods.bigfield.query
     * @param $skuId
     * @param $fieldList
     * @Line https://union.jd.com/openplatform/api/761
     * @return bool|string
     * @throws \Exception
     */
    public function bigFieldQuery($skuIds, $fieldList)
    {
        $params = [
            'goodsReq' => [
                'skuIds' => $skuIds,
                'fields' => $fieldList
            ]
        ];

        $result = $this->send('jd.union.open.goods.bigfield.query', $params);
        return $result;
    }

    /**
     * 根据短链获取落地页
     * @param $shortUrl
     * @return bool
     */
    public function getLinkByShortUrl($shortUrl)
    {
        $html = Helpers::curl_get($shortUrl);
        preg_match("/hrl='(\S+)'/", $html, $regs);
        if (count($regs) > 1) {
            //短链接对应的长链接
            $longurl = $regs[1];
            //用curl获取这个长链接的跳转的302地址
            $url = Helpers::curl_get_302($longurl);
            return $url;
        }
        return false;
    }


    /**
     * 链接商品查询接口【申请】
     * jd.union.open.goods.link.query
     * @param $url 链接
     * @param $subUnionId 子联盟ID（需要联系运营开通权限才能拿到数据）
     * @return bool|string
     * @throws \Exception
     * @api https://union.jd.com/openplatform/api/762
     */
    public function linkQuery($url, $subUnionId)
    {
        $params = [
            'goodsReq' => [
                'url' => $url,
                'subUnionId' => $subUnionId
            ]
        ];

        $result = $this->send('jd.union.open.goods.link.query', $params);
        return $result;
    }
}