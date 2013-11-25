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
    private $cache;
    
    /**
     * Create a mock
     * 
     * @return \Wise\Cache\Cache
     */
    private function getCache()
    {
        if ($this->cache === null) {
            $this->mockGenerator->generate('\Wise\Cache\Driver\Cache', '\Wise\Cache\Driver', 'Mock');

            $controller = new \atoum\mock\controller();
            $controller->__construct = function() { $this->cache = array(); };
            $controller->set         = function($key, $value) { $this->cache[$key] = $value; };
            $controller->get         = function($key) { return (isset($this->cache[$key])) ? $this->cache[$key] : false ;};
            $controller->delete      = function($key) { unset($this->cache[$key]);};
            $controller->flush       = function() { $this->cache = array(); };
            $controller->increment   = function($key) { $this->cache[$key]++; };
            $controller->decrement   = function($key) {  $this->cache[$key]--; };

            $config = array(
                'enable' => true,
                'driver' => 'mock'
            );

            $this->cache = new \Wise\Cache\Cache($config);
        }
        
        return $this->cache;
    }
    
    public function testFlush()
    {
        $this->getCache()->set('flush', 5);
        $this->getCache()->flush();
        $this->assert->boolean($this->getCache()->get('flush'))
                     ->isFalse(6);
    }
    
    public function testGet()
    {
        $this->getCache()->set('get', 'content');
        $this->assert->string($this->getCache()->get('get'))
                     ->isEqualTo('content');
    }
    
    public function testDelete()
    {
        $this->getCache()->set('delete', 'content');
        $this->getCache()->delete('delete');
        $this->assert->boolean($this->getCache()->get('delete'))
                     ->isFalse();
    }
    
    public function testDecrement()
    {
        $this->getCache()->set('decrement', 5);
        $this->getCache()->decrement('decrement');
        $this->assert->integer((int)$this->getCache()->get('decrement'))
                     ->isEqualTo(4);
    }
    
    public function testIncrement()
    {
        $this->getCache()->set('increment', 5);
        $this->getCache()->increment('increment');
        $this->assert->integer((int)$this->getCache()->get('increment'))
                     ->isEqualTo(6);
    }
}