<?php
namespace Telelab\Cache\tests\units;

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
                        'file' => array('ttl' => 10, 'path' => '/tmp')
                    );
                    break;
            }
            $this->cache = new \Telelab\Cache\Cache($config);
        }
        
        return $this->cache;
    }

    public function testGetCacheDisavle()
    {
        $this->getCache('memcache', false)->setCache('test', 'content');
        $this->assert->boolean($this->getCache('memcache', false)->getCache('test'))
            ->isFalse('content');
    }
    
    public function testGetCacheWithMemcacheDriver()
    {
        $this->getCache()->setCache('test', 'content');
        $this->assert->string($this->getCache()->getCache('test'))
                     ->isEqualTo('content');
    }

    public function testGetCacheWithFileDriver()
    {
        $this->getCache('file')->setCache('test', 'content');
        $this->assert->string($this->getCache('file')->getCache('test'))
            ->isEqualTo('content');
    }
}