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
            'version' => '1.0.0',
            'ace' => 1
        ],
        'list' => [
            'item1', 'item2', 'item3', 'item5', 'item4'
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
        $this->assertTrue(isset($res['project.support']));
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

    public function testPrepend()
    {
        $test = 'add test';
        $res = Arr::prepend($this->testArr, $test, 'test');
        $res = Arr::first($res);
        $this->assertEquals($test, $res);
    }

    public function testPull()
    {
        $res = Arr::pull($this->testArr, 'author');
        $this->assertEquals('limx', $res);
        $this->assertArrayNotHasKey('author', $this->testArr);
    }

    public function testShuffle()
    {
        $res = Arr::shuffle($this->testArr);
        $this->assertArrayNotHasKey('author', $res);
        $this->assertArrayHasKey('author', $this->testArr);

    }

    public function testSortRecursive()
    {
        $res = Arr::sortRecursive($this->testArr);
        $this->assertEquals('limx', Arr::first($res));
        $res = Arr::get($res, 'list');
        foreach ($res as $key => $item) {
            $this->assertEquals('item' . ($key + 1), $item);
        }
    }

    public function testWhere()
    {
        $res = Arr::where($this->testArr, function ($item) {
            return $item === 'limx';
        });

        $this->assertEquals(['author' => 'limx'], $res);
    }

    public function testWrap()
    {
        $res = Arr::wrap('limx');
        $this->assertEquals(['limx'], $res);
    }

    public function testCrossJoin()
    {
        // Single dimension
        $this->assertEquals(
            [[1, 'a'], [1, 'b'], [1, 'c']],
            Arr::crossJoin([1], ['a', 'b', 'c'])
        );

        // Square matrix
        $this->assertEquals(
            [[1, 'a'], [1, 'b'], [2, 'a'], [2, 'b']],
            Arr::crossJoin([1, 2], ['a', 'b'])
        );

        // Rectangular matrix
        $this->assertEquals(
            [[1, 'a'], [1, 'b'], [1, 'c'], [2, 'a'], [2, 'b'], [2, 'c']],
            Arr::crossJoin([1, 2], ['a', 'b', 'c'])
        );

        // 3D matrix
        $this->assertEquals(
            [
                [1, 'a', 'I'], [1, 'a', 'II'], [1, 'a', 'III'],
                [1, 'b', 'I'], [1, 'b', 'II'], [1, 'b', 'III'],
                [2, 'a', 'I'], [2, 'a', 'II'], [2, 'a', 'III'],
                [2, 'b', 'I'], [2, 'b', 'II'], [2, 'b', 'III'],
            ],
            Arr::crossJoin([1, 2], ['a', 'b'], ['I', 'II', 'III'])
        );

        // With 1 empty dimension
        $this->assertEquals([], Arr::crossJoin([1, 2], [], ['I', 'II', 'III']));
    }

    public function testExcept()
    {
        $result = Arr::except($this->testArr, 'author');
        $arr = $this->testArr;
        unset($arr['author']);
        $this->assertEquals($arr, $result);
    }

    public function testExceptByValue()
    {
        $result = Arr::exceptByValue($this->testArr, 'limx1');
        $arr = $this->testArr;
        $this->assertEquals($arr, $result);

        $result = Arr::exceptByValue($this->testArr, 'limx');
        unset($arr['author']);
        $this->assertEquals($arr, $result);
    }

    public function testDotArray()
    {
        $result = Arr::dot2Array($this->testArr);
        $this->assertEquals($this->testArr, $result);

        $testArr1 = [
            'user.name' => 'limx',
            'user.sex' => 1,
            'user.age' => 28,
            'test.one.name' => 'test',
            'test.two.name' => 'test2',
            'books' => ['test', 'test2'],
        ];
        $result = Arr::dot2Array($testArr1);
        $this->assertEquals([
            'user' => ['name' => 'limx', 'sex' => 1, 'age' => 28],
            'test' => ['one' => ['name' => 'test'], 'two' => ['name' => 'test2']],
            'books' => ['test', 'test2'],
        ], $result);

        $result = Arr::dot2Array(Arr::dot($this->testArr));
        $this->assertEquals($this->testArr, $result);
    }

}