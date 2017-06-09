<?php
// +----------------------------------------------------------------------
// | Client.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace limx\curl;

use Pimple\Container;
use limx\curl\Exceptions\HttpException;

class Client
{
    public static $_instance;

    public function __construct(Opt $opt)
    {
        $ch = curl_init();
        // 设置抓取的url
        if (isset($opt->url)) {
            curl_setopt($ch, CURLOPT_URL, $opt->url);
        }

        // 启用时会将头文件的信息作为数据流输出。
        if (isset($opt->hearder)) {
            curl_setopt($ch, CURLOPT_HEADER, $opt->hearder);
        }

        // 启用时将获取的信息以文件流的形式返回，而不是直接输出。
        if (isset($opt->returnTransfer)) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, $opt->returnTransfer);
        }

        // 启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
        if (isset($opt->followLocation)) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $opt->followLocation);
        }

        // 设置访问 方法
        if (isset($opt->customRequest)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $opt->customRequest);

        }

        // 设置POST BODY
        if (isset($opt->postFields)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $opt->postFields);
        }

        // 设置header
        if (isset($opt->httpHeader)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $opt->httpHeader);
        }

        static::$_instance = $ch;
    }

    public function get()
    {

    }

    public function post()
    {

    }

    public function execute()
    {
        //执行命令
        $result = curl_exec(static::$_instance);
        if ($result === false) {
            throw new HttpException('Failed to execute: ' . curl_error(static::$_instance));
        }
        //关闭URL请求
        curl_close(static::$_instance);
        return $result;
    }

}