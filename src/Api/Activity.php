<?php


namespace JdMediaSdk\Api;


use JdMediaSdk\Tools\JdGateWay;

class Activity extends JdGateWay
{
    /**
     * jd.union.open.activity.query 活动查询接口
     * @param int $pageIndex
     * @param int $pageSize
     * @return bool|string
     * @throws \Exception
     */
    public function query($pageIndex = 1, $pageSize = 50)
    {
        $params['activityReq'] = [
            'pageIndex' => $pageIndex,
            'pageSize' => $pageSize
        ];
        return $this->send('jd.union.open.activity.query', $params);
    }
}