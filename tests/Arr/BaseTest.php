<?php
// +----------------------------------------------------------------------
// | BaseTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Arr;

use limx\Support\Arr;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function testGet()
    {
        $arr = ['test', 'hello world!'];
        $res = Arr::get($arr, 'test', 'no value');
        print_r($res);
    }
}