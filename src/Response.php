<?php
// +----------------------------------------------------------------------
// | Response.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace limx\curl;

use Pimple\Container;
use limx\curl\Exceptions\HttpException;

class Response
{
    public $result;

    public function __construct()
    {

    }

    public function setContent($result)
    {
        $this->result = $result;
    }

    public function getContent()
    {
        return $this->result;
    }

    public function getJsonContent($assoc = false)
    {
        return json_decode($this->result, $assoc);
    }

}