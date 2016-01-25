<?php

namespace SimpleRoute\Test;

use SimpleRoute\Route;
use SimpleRoute\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testMatch()
    {
        $route = new Route('GET', '/foo', 'foo');
        $router = new Router(array($route));
        $result = $router->match('GET', '/foo');

        $this->assertSame($route, $result->getRoute());
    }

    public function testParams()
    {
        $route = new Route('GET', '/user/{id:\d+}', 'foo');
        $router = new Router(array($route));
        $result = $router->match('GET', '/user/1');

        $this->assertEquals(array('id' => '1'), $result->getParams());
    }

    /**
     * @expectedException SimpleRoute\Exception\NotFoundException
     */
    public function testNotFound()
    {
        $router = new Router(array());
        $router->match('GET', '/foo');
    }

    /**
     * @expectedException SimpleRoute\Exception\MethodNotAllowedException
     */
    public function testMethodNotAllowed()
    {
        $router = new Router(array(
            new Route('GET', '/foo', 'foo')
        ));
        $router->match('POST', '/foo');
    }
}