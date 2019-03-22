<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 10:17
 */

namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\JdGateWay;

class Apith extends JdGateWay
{
    protected $is_auth = true;

    /**
     * @api 优惠券领取情况查询接口【申请】
     * @line https://union.jd.com/openplatform/api/627
     * @param $url
     * @return bool|string
     * @throws \Exception
     */
    public function queryCoupon($url)
    {
        if (is_string($url)) {
            $params['couponUrls'] = $url;
        } else {
            $params['couponUrls'] = implode(',', $url);
        }
        return $this->send('queryCoupon', $params);

    }


    /**
     * @api 关键词商品查询接口【申请】 https://union.jd.com/#/openplatform/api/628
     * @line https://www.coderdoc.cn/jdapiv2?page_id=63
     * @param array $params
     * @return bool|string
     * @throws \Exception
     */
    public function queryGoods(array $params = [])
    {
        if (!isset($params['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
        $result = $this->send('queryGoods', $params);
        return $result;
    }


    /**
     * @api 秒杀商品查询接口【申请】
     * @line https://union.jd.com/openplatform/api/667
     * @param array $params
     * @return bool|string
     * @throws \Exception
     */
    public function querySeckillGoods(array $params = [])
    {
        if (!isset($params['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
        return $this->send('querySeckillGoods', $params);
    }

    /**
     * @api  获取商品的图片集合 【Apith】
     */
    public function getGoodsImageList($skuId)
    {
        $params = [
            'id' => $skuId
        ];
        $result = $this->send('getGoodsImageList', $params);
        return $result;
    }

    /**
     * @api 创建推广位【申请】
     * @link https://union.jd.com/openplatform/api/655
     * @param array $spaceNameList 推广位名称集合，英文 ,分割
     * @param string $key 目标联盟ID对应的授权key，在联盟推广管理页领取
     * @param int $unionType 1：cps推广位 2：cpc推广位
     * @param int $type 站点类型 1网站推广位2.APP推广位3.社交媒体推广位4.聊天工具推广位5.二维码推广
     * @return bool|string
     * @throws \Exception
     */
    public function createPosition(array $spaceNameList, string $key, $unionType = 1, $type = 4)
    {
        $param = [
            'unionId' => $this->unionId,
            'key' => $key,
            'unionType' => $unionType,
            'type' => $type,
            'spaceNameList' => implode(',', $spaceNameList)
        ];
        if ($type == 1) {
            $param = array_merge($param, [
                'siteId' => $this->siteId
            ]);
        }
        return $this->send('createPosition', $param);

    }

    /**
     * @api 查询推广位【申请】
     * @link https://union.jd.com/openplatform/api
     * @param string $key 目标联盟ID对应的授权key，在联盟推广管理页领取
     * @param int $pageIndex 页码，上限10000
     * @param int $pageSize 每页条数，上限100
     * @param int $unionType 联盟推广位类型，1：cps推广位 2：cpc推广位
     * @return bool|string
     * @throws \Exception
     */
    public function queryPosition(string $key, $pageIndex = 1, $pageSize = 100, $unionType = 1)
    {
        $param = [
            'unionId' => $this->unionId,
            'key' => $key,
            'unionType' => $unionType,
            'pageIndex' => $pageIndex,
            'pageSize' => $pageSize
        ];
        return $this->send('queryPosition', $param);
    }

    /**
     * @api 通过unionId获取推广链接
     * @line https://union.jd.com/openplatform/api/631
     * @param $url
     * @param string $conponUrl
     * @param array $params 传入的配置参数
     * @return bool|string
     * @throws \Exception
     */
    public function getByUnionidPromotion($url, $conponUrl = '', $params = [])
    {
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