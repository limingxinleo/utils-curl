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

$curl->opt->url='http://www.baidu.com';
echo $curl->client->execute();