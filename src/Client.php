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

    protected $url;

    protected $data = [];

    protected $headers = [];

    protected $contentType;

    protected $method = null;

    public function __construct(Opt $opt, Response $reponse)
    {
        $this->opt = $opt;
        $this->response = $reponse;
    }

    public function getInstance()
    {
        $ch = curl_init();
        // 设置抓取的url
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());

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
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->getMethod());

        // 设置POST BODY
        if (strtoupper($this->getMethod()) === 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getData());
        }

        // 设置header
        if (!empty($this->getHeaders())) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        }

        return $ch;
    }

    /**
     * @desc   获取请求头信息
     * @author limx
     * @return array
     */
    protected function getHeaders()
    {
        return array_merge(
            isset($this->opt->httpHeader) ? $this->opt->httpHeader : [],
            !empty($this->headers) ? $this->headers : []
        );
    }

    /**
     * @desc   获取请求地址
     * @author limx
     * @return mixed
     * @throws HttpException
     */
    protected function getUrl()
    {
        if (!empty($this->url)) {
            return $this->url;
        }

        if (!empty($this->opt->url)) {
            return $this->opt->url;
        }

        throw new HttpException('Failed to get target Url!');

    }

    /**
     * @desc   获取请求的数据
     * @author limx
     * @return string
     * @throws HttpException
     */
    protected function getData()
    {
        switch ($this->contentType) {
            case 'json':
                $data = json_encode($this->data);
                $this->setHeaders([
                    'Content-Type' => 'application/json',
                    'Content-Length' => strlen($data)
                ]);
                return json_encode($data);
            default:
                return http_build_query($this->data);
        }

        throw new HttpException('Failed to get input Data!');
    }

    /**
     * @desc   获取请求方法
     * @author limx
     * @return null|string
     */
    protected function getMethod()
    {
        if (isset($this->method)) {
            return $this->method;
        }
        if (isset($this->opt->customRequest)) {
            return $this->opt->customRequest;
        }
        return "GET";
    }

    /**
     * @desc   设置请求地址
     * @author limx
     * @param null $url
     * @return $this
     */
    public function setUrl($url = null)
    {
        if (isset($url)) {
            if (strtoupper($this->getMethod()) === 'GET') {
                $params = '';
                if (strpos($url, '?') > 0) {
                    $params = '&' . http_build_query($this->data);
                } else {
                    $params = '?' . http_build_query($this->data);
                }
                $this->url = $url . $params;
            } else {
                $this->url = $url;
            }
        }
        return $this;
    }

    /**
     * @desc   设置请求头信息
     * @author limx
     * @param array $input
     * @return $this
     */
    public function setHeaders($input = [])
    {
        $req = [];
        foreach ($input as $key => $value) {
            $req[] = sprintf("%s:%s", $key, $value);
        }
        $this->headers = array_merge($this->headers, $req);
        return $this;
    }

    /**
     * @desc   设置请求数据
     * @author limx
     * @param array $input
     * @return $this
     */
    public function setData($input = [])
    {
        $this->data = array_merge($this->data, $input);;
        return $this;
    }

    /**
     * @desc   请求数据类型 JSON
     * @author limx
     * @param null $contentType
     * @return $this
     */
    public function format($contentType = null)
    {
        if (isset($contentType)) {
            $this->contentType = $contentType;
        }
        return $this;
    }

    /**
     * @desc   Curl Get方法
     * @author limx
     * @param array ...$params
     * @return Response
     */
    public function get(...$params)
    {
        $this->method = "GET";
        return $this->execute(...$params);
    }

    /**
     * @desc   Curl Post方法
     * @author limx
     * @param array ...$params
     * @return Response
     */
    public function post(...$params)
    {
        $this->method = "POST";
        return $this->execute(...$params);
    }

    /**
     * @desc   Curl 执行方法
     * @author limx
     * @param null  $url
     * @param array $params
     * @return Response
     * @throws HttpException
     */
    public function execute($url = null, $params = [])
    {
        $this->setData($params);
        $this->setUrl($url);

        $_instance = $this->getInstance();
        //执行命令
        $result = curl_exec($_instance);
        if ($result === false) {
            throw new HttpException('Failed to execute: ' . curl_error($_instance));
        }
        //关闭URL请求
        curl_close($_instance);
        $this->response->setContent($result);
        $this->clear();
        return $this->response;
    }

    /**
     * @desc   清理临时数据
     * @author limx
     */
    protected function clear()
    {
        $this->data = [];
        $this->headers = [];
        $this->contentType = null;
        $this->url = null;
        $this->method = null;
    }

}