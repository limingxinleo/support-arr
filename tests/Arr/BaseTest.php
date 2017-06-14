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
    private $testArr = [
        'author' => 'limx',
        'project' => [
            'support' => 'Arr',
            'version' => '1.0.0'
        ],
        'list' => [
            'item1', 'item2', 'item3'
        ],
    ];

    public function testGet()
    {
        $arr = ['test' => 'hello world!'];
        $res = Arr::get($arr, 'test', 'no value');
        $this->assertEquals('hello world!', $res);
    }

    public function testSet()
    {
        $arr = [];
        $res = Arr::set($arr, 'test', 'hello world!');
        $this->assertArrayHasKey('test', $arr);
    }

    public function testAccessible()
    {
        $this->assertTrue(Arr::accessible($this->testArr));
    }

    public function testAdd()
    {
        $res = Arr::add($this->testArr, 'test', 'hello world!');
        $this->assertArrayHasKey('test', $res);
    }

    public function testCollapse()
    {
        $res = Arr::collapse($this->testArr);
        $this->assertArrayHasKey('support', $res);
    }

    public function testDivide()
    {
        $res = Arr::divide($this->testArr);
        $this->assertTrue(count($res[0]) === count($res[1]));
    }

    public function testDot()
    {
        $res = Arr::dot($this->testArr);
        $this->assertEquals(
            Arr::get($this->testArr, 'project.support'),
            $res['project.support']
        );
    }

    public function testHas()
    {
        $res = Arr::has($this->testArr, 'project.support');
        $this->assertTrue($res);
    }

    public function testIsAssoc()
    {
        $res = Arr::isAssoc($this->testArr);
        $this->assertTrue($res);

        $res = Arr::isAssoc([1, 2, 3, '55', 5]);
        $this->assertTrue(!$res);

    }

    public function testOnly()
    {
        $res = Arr::only($this->testArr, ['project', 'author']);
        $this->assertArrayHasKey('project', $res);
        $this->assertArrayHasKey('author', $res);
        $this->assertArrayNotHasKey('list', $res);
    }

    public function testPluck()
    {
        $arr = [
            ['test' => 1, 'test2' => ['t' => 2, 't2' => 3]],
            ['test' => 1, 'test2' => ['t' => 2, 't2' => 3]],
            ['test' => 1, 'test2' => ['t' => 2, 't2' => 3]],
            ['test' => 1, 'test2' => ['t' => 2, 't2' => 3]],
        ];
        $res = Arr::pluck($arr, ['test']);
        foreach ($res as $item) {
            $this->assertEquals(1, $item);
        }
        $res = Arr::pluck($arr, ['test2', 't2']);
        foreach ($res as $item) {
            $this->assertEquals(3, $item);
        }
    }

}