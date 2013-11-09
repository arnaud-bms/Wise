<?php
namespace Wise\Cache\tests\units;

use atoum;

/**
 * Tests on the Cache component
 *
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Cache extends atoum
{
    
    private $cache;
    
    private function getCache($driver = 'memcache', $enable = true)
    {
        if ($this->cache === null) {

            switch($driver) {
                case 'memcache':
                    $config = array(
                        'enable' => $enable,
                        'driver' => 'memcache',
                        'memcache' => array('ttl' => 10, 'host' => '127.0.0.1', 'port' => 11211)
                    );
                    break;
                case 'file':
                    $config = array(
                        'enable' => $enable,
                        'driver' => 'file',
                        'file' => array('ttl' => 600, 'path' => '/tmp/cache')
                    );
                    break;
                case 'fake':
                    $config = array(
                        'enable' => $enable,
                        'driver' => 'fake'
                    );
                    break;
            }
            $this->cache = new \Wise\Cache\Cache($config);
        }
        
        return $this->cache;
    }
    
    public function testFlushWithFileDriver()
    {
        $this->testIncrement('file');
    }
    
    public function testFlushWithMemcacheDriver()
    {
        $this->testIncrement('memcache');
    }
    
    protected function testFlush($driver)
    {
        $this->getCache($driver)->set('flush', 5);
        $this->getCache($driver)->flush();
        $this->assert->boolean($this->getCache($driver)->get('flush'))
                     ->isFalse(6);
    }

    public function testGetDisable()
    {
        $this->getCache('memcache', false)->set('disable', 'content');
        $this->assert->boolean($this->getCache('memcache', false)->get('disable'))
            ->isFalse();
    }
    
    public function testGetWithMemcacheDriver()
    {
        $this->testGet('memcache');
    }

    public function testGetWithFileDriver()
    {
        $this->testGet('file');
    }
    
    protected function testGet($driver)
    {
        $this->getCache($driver)->set('get', 'content');
        $this->assert->string($this->getCache($driver)->get('get'))
            ->isEqualTo('content');
    }
    
    public function testgetWithFakeDriver()
    {
        $this->exception(function() {
            $this->getCache('fake');
        })
            ->isInstanceOf('\Wise\Cache\Exception');
    }
    
    public function testDeleteWithFileDriver()
    {
        $this->testDelete('file');
    }
    
    public function testDeleteWithMemcacheDriver()
    {
        $this->testDelete('memcache');
    }
    
    protected function testDelete($driver)
    {
        $this->getCache($driver)->set('delete', 'content');
        $this->getCache($driver)->delete('delete');
        $this->assert->boolean($this->getCache($driver)->get('delete'))
                     ->isFalse();
    }
    
    public function testDecrementWithFileDriver()
    {
        $this->testDecrement('file');
    }
    
    public function testDecrementWithMemcacheDriver()
    {
        $this->testDecrement('memcache');
    }
    
    protected function testDecrement($driver)
    {
        $this->getCache($driver)->set('decrement', 5);
        $this->getCache($driver)->decrement('decrement');
        $this->assert->integer((int)$this->getCache($driver)->get('decrement'))
                     ->isEqualTo(4);
    }
    
    public function testIncrementWithFileDriver()
    {
        $this->testIncrement('file');
    }
    
    public function testIncrementWithMemcacheDriver()
    {
        $this->testIncrement('memcache');
    }
    
    protected function testIncrement($driver)
    {
        $this->getCache($driver)->set('increment', 5);
        $this->getCache($driver)->increment('increment');
        $this->assert->integer((int)$this->getCache($driver)->get('increment'))
                     ->isEqualTo(6);
    }
}