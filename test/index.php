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

$curl->opt->setUrl('https://demo.phalcon.lmx0536.cn/test/api/api');
$body = ['test' => 1, 'test2' => 2];
$curl->opt->setBody($body);
$curl->opt->setHeader('Header-Test', 1);
$curl->opt->setHeader('Header-Test2', 3);
$result = $curl->client->execute();
print_r(json_decode($result, true));

$result = $curl->client->get();
print_r(json_decode($result, true));