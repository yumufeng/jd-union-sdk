**京东联盟SDK**
自用包

API列表地址：https://union.jd.com/#/openplatform/api

### 使用说明

高级权限和基础权限封装基于两部分

基础权限传参参考：https://union.jd.com/#/openplatform/api

高级权限传参参考：https://www.coderdoc.cn/jdapiv2?page_id=63




### 使用示例

```php
$config = [
    'appkey' => '',
    'appSecret' => '',
    'unionId' => '',
    'positionId' => '',
    'siteId' => ''
];
$client = new \JdMediaSdk\JdFatory($config);
$result = $client->promotion->order([
    'pageNo' => 1,
    'pageSize' => 500,
    'type' => 1,
    'time' => "201810032339"
]);

if (!is_array($result)) {
    var_dump($client->getError());
}

```



