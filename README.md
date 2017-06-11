## Curl 类

### 安装
~~~
composer require limingxinleo/utils-curl
~~~

### 使用方法
~~~
use limx\curl\Application;

$curl = new Application();

$curl->opt->setUrl('https://demo.phalcon.lmx0536.cn/test/api/api?get=3');
$body = http_build_query(['post' => 1, 'post2' => 2]);
$curl->opt->setBody($body);
$curl->opt->setHeader('Header-Test', 1);
$curl->opt->setHeader('Header-Test2', 3);

$result = $curl->client->execute()->getJsonContent();
print_r($result);

$result = $curl->client->get()->getContent();
print_r(json_decode($result, true));
~~~
