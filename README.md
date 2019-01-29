**京东联盟SDK**

京东联盟SDK，基于新版的

PHP =>7.0

`composer require yumufeng/jd-union-sdk`


由于自己没有高级接口，所以高级权限和基础权限封装是分开成两部分的。

哪位大佬能提供*原生*高级API密钥的，可以联系我：QQ 445328312 (京东联盟)

### 使用示例

```php
$config = [
    'appkey' => '', // AppId
    'appSecret' => '', // 密钥
    'unionId' => '', // 联盟ID
    'positionId' => '', // 推广位ID
    'siteId' => '' // 网站ID
];
$client = new \JdMediaSdk\JdFatory($config);

$result = $client->promotion->order([
    'pageNo' => 1,
    'pageSize' => 500,
    'type' => 1,
    'time' => "201810032339"
]);

if ($result == false ) {
    var_dump($client->getError());
}

```

## 说明文档

以下**基础权限**传参参考：https://union.jd.com/#/openplatform/api

| 接口名称 [**基础**]   | 对应方法  |
| --------   | ---- |
| jd.union.open.order.query (订单查询接口)     | \$client->promotion->order() |
| jd.union.open.goods.promotiongoodsinfo.query (获取推广商品信息接口)     | \$client->good->info() |
| jd.union.open.category.goods.get(商品类目查询)     | \$client->good->category() |
| jd.union.open.user.pid.get(获取PID)     | \$client->promotion->pid() |
| jd.union.open.promotion.common.get(获取通用推广链接)     | \$client->link->get() |
| jd.union.open.goods.jingfen.query (京粉精选商品查询接口)     | \$client->good->jingfen() |
| jd.union.open.goods.detail.query (京东商品详情接口)     | \$client->good->detail() |

以下**高级权限**传参参考：https://www.coderdoc.cn/jdapiv2?page_id=63

| 接口名称 [**高级**]   | 对应方法  |
| --------   | ---- |
|jd.union.open.coupon.query(优惠券领取情况查询接口【**申请**】)   | \$client->coupon->query()   |
|jd.union.open.goods.seckill.query(秒杀商品查询接口【**申请**】)   | \$client->good->seckill()   |
|jd.union.open.goods.query(关键词商品查询接口【**申请**】)   | \$client->good->query()   |
|jd.union.open.promotion.byunionid.get(通过unionId获取推广链接【**申请**】)   | \$client->link->byUnionId()   |
|jd.union.open.coupon.importation(优惠券导入【**申请**】)   | \$client->coupon->importation()   |
|jd.union.open.position.query(查询推广位【**申请**】)   | \$client->promotion->queryPosition()   |
|jd.union.open.position.create(创建推广位【**申请**】)   | \$client->promotion->createPosition()   |


## License

MIT



