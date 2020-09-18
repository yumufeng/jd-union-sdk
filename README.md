**京东联盟SDK**

京东联盟SDK，基于新版的

PHP =>7.0

`composer require yumufeng/jd-union-sdk`

如果是在swoole 扩展下使用，支持协程并发，需要在编译swoole扩展的时候开启，系统会自动判断是否采用swoole

```./configure --enable-openssl```

由于自己没有高级接口，所以高级权限和基础权限封装是分开成两部分的。

没有获取高级权限的，可以申请Apith的高级接口：https://apith.cn/invite/4SO80R60 （用github登录即可 ，28元/月，收费的哦）

### 使用示例

```php
$config = [
    'appkey' => '', // AppId
    'appSecret' => '', // 密钥
    'unionId' => '', // 联盟ID
    'positionId' => '', // 推广位ID
    'siteId' => '', // 网站ID,
    'apithId' => '',  // 第三方网站Apith的appid （可选，不使用apith的，可以不用填写）
    'apithKey' => '', // 第三方网站Apith的appSecret (可选，不使用apith的，可以不用填写)
    'isCurl' => true // 设置为true的话，强制使用php的curl，为false的话，在swoole cli环境下自动启用 http协程客户端
];
$client = new \JdMediaSdk\JdFatory($config);
$result = $client->apith->querySeckillGoods();
if ($result == false ) {
    var_dump($client->getError());
}

var_dump($result);

```


## 说明文档


### 1.官方版本

以下**官方版本**传参参考：https://union.jd.com/#/openplatform/api

| 接口名称 [**基础**]   | 对应方法  |
| --------   | ---- |
| jd.union.open.order.query (订单查询接口)     | \$client->promotion->order() |
| jd.union.open.goods.promotiongoodsinfo.query (获取推广商品信息接口)     | \$client->good->info() |
| jd.union.open.category.goods.get(商品类目查询)     | \$client->good->category() |
| jd.union.open.user.pid.get(获取PID)     | \$client->promotion->pid() |
| jd.union.open.promotion.common.get(获取通用推广链接)     | \$client->link->get() |
| jd.union.open.goods.jingfen.query (京粉精选商品查询接口)     | \$client->good->jingfen() |
| 根据短链查询出落地页  | \$client->good->getLinkByShortUrl()   |
| jd.union.open.statistics.giftcoupon.query(活动查询接口)   | \$client->activity->query()   |


| 接口名称 [**高级**] **官方版**   | 对应方法  |
| --------   | ---- |
|jd.union.open.coupon.query(优惠券领取情况查询接口【**申请**】)   | \$client->coupon->query()   |
|jd.union.open.goods.seckill.query(秒杀商品查询接口【**申请**】)   | \$client->good->seckill()   |
|jd.union.open.goods.query(关键词商品查询接口【**申请**】)   | \$client->good->query()   |
|jd.union.open.promotion.bysubunionid.get(社交媒体获取推广链接接口【**申请**】)   | \$client->link->bySubUnionId()   |
|jd.union.open.promotion.byunionid.get(通过unionId获取推广链接【**申请**】)   | \$client->link->byUnionId()   |
|jd.union.open.coupon.importation(优惠券导入【**申请**】)   | \$client->coupon->importation()   |
|jd.union.open.position.query(查询推广位【**申请**】)   | \$client->promotion->queryPosition()   |
|jd.union.open.goods.bigfield.query(大字段商品查询接口（内测版）【**申请**】)   | \$client->good->bigFieldQuery()   |
|jd.union.open.coupon.gift.get(礼金创建【**申请**】)   | \$client->gift->get()   |
|jd.union.open.coupon.gift.stop(礼金停止【**申请**】)   | \$client->gift->stop()   |
|jd.union.open.statistics.giftcoupon.query(礼金停止【**申请**】)   | \$client->gift->query()   |


### 2.京佣版


没有**高级权限**的，可以点击 加QQ 445328312 辅助获取 京佣 高级权限（由于时间有限 100人/次 服务费用，一次开通，永久使用，不限制调用量）

| 接口名称 [**高级**]  **京佣版** | 对应方法  |
| --------   | ---- |
|关键词商品查询接口【**申请**】   | \$client->jingyong->queryGood()   |
|订单查询接口,支持“subid”进行返利跟踪【**申请**】   | \$client->jingyong->order()   |
|长短转链接口,支持“subid”进行返利跟踪【**申请**】   | \$client->jingyong->convert()   |


### 3.Apith版


没有**Apith高级权限**的，可以点击 https://apith.cn/invite/4SO80R60 （用github登录即可 ，28元/月，收费的哦）。

| 接口名称 [**高级**]  **Apith版** | 对应方法  |
| --------   | ---- |
|jd.union.open.coupon.query(优惠券领取情况查询接口【**申请**】)   | \$client->apith->queryCoupon()   |
|jd.union.open.goods.seckill.query(秒杀商品查询接口【**申请**】)   | \$client->apith->querySeckillGoods()   |
|jd.union.open.goods.query(关键词商品查询接口【**申请**】)   | \$client->apith->queryGoods()   |
|jd.union.open.promotion.byunionid.get(通过unionId获取推广链接【**申请**】)   | \$client->apith->getByUnionidPromotion()   |
|jd.union.open.position.query(查询推广位【**申请**】)   | \$client->apith->queryPosition()   |
|jd.union.open.position.create(创建推广位【**申请**】)   | \$client->apith->createPosition()   |
|商品主图列表查询【**申请**】   | \$client->apith->getGoodsImageList()   |
|根据短链查询出落地页【**申请**】   | \$client->apith->getLinkByShort()   |
|根据短链接查询商品编号【**申请**】   | \$client->apith->getSkuIdByShort()   |
## License

Apache 






