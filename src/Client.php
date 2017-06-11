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
    public $opt;

    public $response;

    public function __construct(Opt $opt, Response $reponse)
    {
        $this->opt = $opt;
        $this->response = $reponse;
    }

    public function getInstance()
    {
        $ch = curl_init();
        // 设置抓取的url
        if (isset($this->opt->url)) {
            curl_setopt($ch, CURLOPT_URL, $this->opt->url);
        }

        // 启用时会将头文件的信息作为数据流输出。
        if (isset($this->opt->hearder)) {
            curl_setopt($ch, CURLOPT_HEADER, $this->opt->hearder);
        }

        // 启用时将获取的信息以文件流的形式返回，而不是直接输出。
        if (isset($this->opt->returnTransfer)) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, $this->opt->returnTransfer);
        }

        // 启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
        if (isset($this->opt->followLocation)) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->opt->followLocation);
        }

        // 设置访问 方法
        if (isset($this->opt->customRequest)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->opt->customRequest);

        }

        // 设置POST BODY
        if (isset($this->opt->postFields)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->opt->postFields);
        }

        // 设置header
        if (isset($this->opt->httpHeader)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->opt->httpHeader);
        }

        return $ch;
    }

    public function get()
    {
        $this->opt->customRequest = "GET";
        return $this->execute();
    }

    public function post()
    {
        $this->opt->customRequest = "POST";
        return $this->execute();
    }

    public function execute()
    {
        $_instance = $this->getInstance();
        //执行命令
        $result = curl_exec($_instance);
        if ($result === false) {
            throw new HttpException('Failed to execute: ' . curl_error($_instance));
        }
        //关闭URL请求
        curl_close($_instance);
        $this->response->setContent($result);
        return $this->response;
    }

}