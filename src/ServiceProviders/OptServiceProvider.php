<?php
// +----------------------------------------------------------------------
// | ConfigServiceProvider.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace limx\curl\ServiceProviders;

use limx\curl\Opt;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OptServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['opt'] = function ($pimple) {
            return new Opt();
        };
    }

}
