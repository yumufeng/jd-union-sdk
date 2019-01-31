<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/25
 * Time: 10:02
 */

namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\JdGateWay;

class Promotion extends JdGateWay
{
    /**
     * @api 订单查询接口 （查询级别，分钟查询）
     * @line https://union.jd.com/#/openplatform/api/650
     * @param array $params
     * @return bool|string
     */

    public function order(array $params)
    {
        if (!isset($params['pageNo'])) {
            $params['pageNo'] = 1;
        }
        if (!isset($params['pageSize'])) {
            $params['pageSize'] = 100;
        }
        $reqParams = [
            'orderReq' => $params,
        ];
        $result = $this->send('jd.union.open.order.query', $reqParams, true);
        return $result;
    }


    /**
     * @api 获取PID
     * @line https://union.jd.com/#/openplatform/api/646
     * @param array $params
     * @return bool|string
     */
    public function pid(array $params)
    {
        $reqParams = [
            'pidReq' => $params,
        ];
        $result = $this->send('jd.union.open.user.pid.get', $reqParams);
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
     */
    public function createPosition(array $spaceNameList, string $key, $unionType = 1, $type = 4)
    {
        $this->setIsAuth(true);
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
     */
    public function queryPosition(string $key, $pageIndex = 1, $pageSize = 100, $unionType = 1)
    {
        $this->setIsAuth(true);
        $param = [
            'unionId' => $this->unionId,
            'key' => $key,
            'unionType' => $unionType,
            'pageIndex' => $pageIndex,
            'pageSize' => $pageSize
        ];
        return $this->send('queryPosition', $param);
    }
}