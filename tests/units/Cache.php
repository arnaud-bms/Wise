<?php
namespace Wise\Cache\tests\units;

use atoum;

/**
 * Class \Wise\Cache\tests\units\Cache
 * 
 * This class tests the Cache component
 *
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Cache extends atoum
{
    
    public function beforeTestMethod()
    {
        $controller = new \atoum\mock\controller();
        $controller->__construct = function() { $this->cache = array(); };
        $controller->set         = function($key, $value) { $this->cache[$key] = $value; };
        $controller->get         = function($key) { return (isset($this->cache[$key])) ? $this->cache[$key] : false ;};
        $controller->delete      = function($key) { unset($this->cache[$key]);};
        $controller->flush       = function() { $this->cache = array(); };
        $controller->increment   = function($key) { $this->cache[$key]++; };
        $controller->decrement   = function($key) {  $this->cache[$key]--; };
        
        $this->mockGenerator->generate('\Wise\Cache\Driver\Cache', '\Wise\Cache\Driver', 'Mock');
    }
    
    public function testFlush()
    {
        $this
            ->if($config = array('enable' => true, 'driver' => 'mock'))
            ->and($cache = new \Wise\Cache\Cache($config))
            ->and($cache->set('flush', 5))
            ->and($cache->flush())
            ->then
                ->boolean($cache->get('flush'))->isFalse(6)
        ;
    }
    
    public function testGet()
    {
        $this
            ->if($config = array('enable' => true, 'driver' => 'mock'))
            ->and($cache = new \Wise\Cache\Cache($config))
            ->and($cache->set('get', 'content'))
            ->then
                ->string($cache->get('get'))->isEqualTo('content')
        ;
                     
    }
    
    public function testDelete()
    {
        $this
            ->if($config = array('enable' => true, 'driver' => 'mock'))
            ->and($cache = new \Wise\Cache\Cache($config))
            ->and($cache->set('delete', 'content'))
            ->and($cache->delete('delete'))
            ->then
                ->boolean($cache->get('delete'))->isFalse()
        ;
    }
    
    public function testDecrement()
    {
        $this
            ->if($config = array('enable' => true, 'driver' => 'mock'))
            ->and($cache = new \Wise\Cache\Cache($config))
            ->and($cache->set('decrement', 5))
            ->and($cache->decrement('decrement'))
            ->then
                ->integer((int)$cache->get('decrement'))->isEqualTo(4)
        ;
    }
    
    public function testIncrement()
    {
        $this
            ->if($config = array('enable' => true, 'driver' => 'mock'))
            ->and($cache = new \Wise\Cache\Cache($config))
            ->and($cache->set('increment', 5))
            ->and($cache->increment('increment'))
            ->then
                ->integer((int)$cache->get('increment'))->isEqualTo(6)
        ;
    }
}