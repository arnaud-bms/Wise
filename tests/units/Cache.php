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
    
    public function _testFlushWithFileDriver()
    {
        $this->testIncrement('file');
    }
    
    public function _testFlushWithMemcacheDriver()
    {
        $this->testIncrement('memcache');
    }
    
    protected function _testFlush($driver)
    {
        $this->getCache($driver)->set('flush', 5);
        $this->getCache($driver)->flush();
        $this->assert->boolean($this->getCache($driver)->get('flush'))
                     ->isFalse(6);
    }

    public function _testGetDisable()
    {
        $this->getCache('memcache', false)->set('disable', 'content');
        $this->assert->boolean($this->getCache('memcache', false)->get('disable'))
            ->isFalse();
    }
    
    public function _testGetWithMemcacheDriver()
    {
        $this->testGet('memcache');
    }

    public function _testGetWithFileDriver()
    {
        $this->testGet('file');
    }
    
    protected function _testGet($driver)
    {
        $this->getCache($driver)->set('get', 'content');
        $this->assert->string($this->getCache($driver)->get('get'))
            ->isEqualTo('content');
    }
    
    public function _testgetWithFakeDriver()
    {
        $this->exception(function() {
            $this->getCache('fake');
        })
            ->isInstanceOf('\Wise\Cache\Exception');
    }
    
    public function _testDeleteWithFileDriver()
    {
        $this->testDelete('file');
    }
    
    public function _testDeleteWithMemcacheDriver()
    {
        $this->testDelete('memcache');
    }
    
    protected function _testDelete($driver)
    {
        $this->getCache($driver)->set('delete', 'content');
        $this->getCache($driver)->delete('delete');
        $this->assert->boolean($this->getCache($driver)->get('delete'))
                     ->isFalse();
    }
    
    public function _testDecrementWithFileDriver()
    {
        $this->testDecrement('file');
    }
    
    public function _testDecrementWithMemcacheDriver()
    {
        $this->testDecrement('memcache');
    }
    
    protected function _testDecrement($driver)
    {
        $this->getCache($driver)->set('decrement', 5);
        $this->getCache($driver)->decrement('decrement');
        $this->assert->integer((int)$this->getCache($driver)->get('decrement'))
                     ->isEqualTo(4);
    }
    
    public function _testIncrementWithFileDriver()
    {
        $this->testIncrement('file');
    }
    
    public function _testIncrementWithMemcacheDriver()
    {
        $this->testIncrement('memcache');
    }
    
    protected function _testIncrement($driver)
    {
        $this->getCache($driver)->set('increment', 5);
        $this->getCache($driver)->increment('increment');
        $this->assert->integer((int)$this->getCache($driver)->get('increment'))
                     ->isEqualTo(6);
    }
}