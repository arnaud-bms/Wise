<?php
namespace Wise\Router\tests\units;

use atoum;

/**
 * Tests on the router component
 *
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Router extends atoum
{
    public function testAddRoute()
    {
        $this
            ->if($config = $this->getConfig())
            ->and($router = new \Wise\Router\Router($config))
            ->then
                ->exception(function() use($router) { $router->addRoute('test', array()); })
                    ->hasMessage('The field "pattern" is missed for the route "test"')
            ->if($router->addRoute('app_name@test', array('pattern' => '/')))
                ->array($router->getRoute('/'))
                    ->hasKey('name')->contains('app_name@test')
                    ->hasKey('pattern')->contains('/')
                    ->hasKey('sapi')->contains('cli')
                ->array($router->getRoute('/default'))
                    ->hasKey('name')->contains('route_name')
                    ->hasKey('pattern')->contains('/default')
                ->exception(function() use($router) { $router->getRoute('/test'); })
                    ->hasMessage('The route "/test" not matches')
            ->if($router = new \Wise\Router\Router())
            ->then
                ->exception(function() use($router) { $router->addRoute('test', array()); })
                    ->hasMessage('The field "pattern" is missed for the route "test"')
            ->if($router->addRoute('app_name@test', array('pattern' => '/')))
                ->array($router->getRoute('/'))
                    ->hasKey('name')->contains('app_name@test')
                    ->hasKey('pattern')->contains('/')
                    ->notHasKey('sapi')
                ->exception(function() use($router) { $router->getRoute('/test'); })
                    ->hasMessage('The route "/test" not matches')
        ;
    }
    
    public function testDeleteRoute()
    {
        $this
            ->if($config = $this->getConfig())
            ->and($router = new \Wise\Router\Router($config))
            ->and($router->addRoute('app_name@test', array('pattern' => '/')))
                ->array($router->getRoute('/'))
                    ->hasKey('name')->contains('app_name@test')
                    ->hasKey('pattern')->contains('/')
                    ->hasKey('sapi')->contains('cli')
                ->exception(function() use($router) { $router->getRoute('/test'); })
                    ->hasMessage('The route "/test" not matches')
            ->and($router->deleteRoute('app_name@test'))
            ->then
                ->exception(function() use($router) { $router->getRoute('/'); })
                    ->hasMessage('The route "/" not matches')
                ->exception(function() use($router) { $router->deleteRoute('app_name@test'); })
                    ->hasMessage('The route "app_name@test" does not exist')
        ;
    }
    
    public function testGetRoute()
    {
        $this
            ->if($config = $this->getConfig())
            ->and($router = new \Wise\Router\Router($config))
            ->if($router->addRoute('app_name@test', array('pattern' => '/')))
                ->array($router->getRoute('/'))
                    ->hasKey('name')->contains('app_name@test')
                    ->hasKey('pattern')->contains('/')
                    ->hasKey('sapi')->contains('cli')
        ;
    }
    
    private function getConfig()
    {
        return array(
            'default' => array(
                'app_name' => array(
                    'sapi' => 'cli'
                )
            ),
            'routes' => array(
                'route_name' => array(
                    'pattern' => '/default'
                )
            )
        );
    }
}