<?php
// +----------------------------------------------------------------------
// | Config.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace limx\curl;

use Pimple\Container;

class Opt
{
    // 设置抓取的url
    public $url;

    // 启用时会将头文件的信息作为数据流输出。
    public $hearder = false;

    // 启用时将获取的信息以文件流的形式返回，而不是直接输出。
    public $returnTransfer = true;

    // 启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
    public $followLocation = 1;

    // 请求方法 GET POST
    public $customRequest;

    // 请求的数据
    public $postFields;

    // 请求的头信息
    public $httpHeader;

    public function __construct()
    {

    }

    public function setMethod($method)
    {
        $this->customRequest = $method;
    }

    public function setBody($body)
    {
        $this->postFields = $body;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setHeader($key, $value)
    {
        $this->httpHeader[] = "$key:$value";
    }

}