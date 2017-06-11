<?php
// +----------------------------------------------------------------------
// | index.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------

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
