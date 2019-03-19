**京东联盟SDK**

京东联盟SDK，基于新版的

PHP =>7.0

`composer require yumufeng/jd-union-sdk`


由于自己没有高级接口，所以高级权限和基础权限封装是分开成两部分的。

哪位大佬能提供*原生*高级API密钥的，可以联系我封装：QQ 445328312 (京东联盟，不提供免费技术咨询)

### 使用示例

```php
$config = [
    'appkey' => '', // AppId
    'appSecret' => '', // 密钥
    'apithId' => '',  // 第三方网站Apith的appid （可选，不使用apith的，可以不用填写）
    'apithKey' => '', // 第三方网站Apith的appSecret (可选，不使用apith的，可以不用填写)
    'unionId' => '', // 联盟ID
    'positionId' => '', // 推广位ID
    'siteId' => '' // 网站ID
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

| 接口名称 [**高级**] **官方版**   | 对应方法  |
| --------   | ---- |
|jd.union.open.coupon.query(优惠券领取情况查询接口【**申请**】)   | \$client->coupon->query()   |
|jd.union.open.goods.seckill.query(秒杀商品查询接口【**申请**】)   | \$client->good->seckill()   |
|jd.union.open.goods.query(关键词商品查询接口【**申请**】)   | \$client->good->query()   |
|jd.union.open.promotion.byunionid.get(通过unionId获取推广链接【**申请**】)   | \$client->link->byUnionId()   |
|jd.union.open.coupon.importation(优惠券导入【**申请**】)   | \$client->coupon->importation()   |
|jd.union.open.position.query(查询推广位【**申请**】)   | \$client->promotion->queryPosition()   |
|jd.union.open.position.create(创建推广位【**申请**】)   | \$client->promotion->createPosition()   |





### 2.Apith版


没有高级权限的，可以点击 https://apith.cn/invite/4SO80R60 用github登录，免费申请。

| 接口名称 [**高级**]  **Apith版** | 对应方法  |
| --------   | ---- |
|jd.union.open.coupon.query(优惠券领取情况查询接口【**申请**】)   | \$client->apith->queryCoupon()   |
|jd.union.open.goods.seckill.query(秒杀商品查询接口【**申请**】)   | \$client->apith->querySeckillGoods()   |
|jd.union.open.goods.query(关键词商品查询接口【**申请**】)   | \$client->apith->queryGoods()   |
|jd.union.open.promotion.byunionid.get(通过unionId获取推广链接【**申请**】)   | \$client->apith->getByUnionidPromotion()   |
|jd.union.open.position.query(查询推广位【**申请**】)   | \$client->apith->queryPosition()   |
|jd.union.open.position.create(创建推广位【**申请**】)   | \$client->apith->createPosition()   |



## License

MIT



