## Curl 类

### 安装
~~~
composer require limingxinleo/utils-curl
~~~

### 使用方法
* GET 方法
~~~
require_once 'vendor/autoload.php';

use limx\curl\Application;

$curl = new Application();
// 可以在opt中设置header
$curl->opt->setHeader("Opt-Test", 'Opt-Value');

$url = 'https://demo.phalcon.lmx0536.cn/test/api/api?get=simpleGet';
$params = [
    'get1' => 1,
    'get2' => 2,
];
// 在Client中设置Header
$header = [
    'Client-Test' => 'Client-Value'
];
$result = $curl->client->setHeaders($header)->get($url, $params)->getJsonContent();
print_r($result);

~~~

* Post
~~~
require_once 'vendor/autoload.php';

use limx\curl\Application;

$curl = new Application();
$url = 'https://demo.phalcon.lmx0536.cn/test/api/api?get=simpleGet';
$params = [
    'get1' => 1,
    'get2' => 2,
];
$headers = [
    'Header-Test' => '1',
];

// Content-Type=application/x-www-form-urlencoded
$result = $curl->client->setHeaders($headers)->post($url, $params)->getJsonContent();
print_r($result);

// Content-Type=json
$result = $curl->client->setHeaders($headers)->format('json')->post($url, $params)->getJsonContent();
print_r($result);

~~~
