<?php
namespace Telelab\Cache\tests\units;

use atoum;

/**
 * Test  \Telelab\Autoloader
 *
 * @author Guillaume Dievart <g.dievart@telemaque.fr>
 */
class Cache extends atoum
{
    
    private $cache;
    
    private function getCache()
    {
        if ($this->cache === null) {
            $config = array(
                'enable' => true,
                'driver' => 'memcache',
                'memcache' => array('ttl' => 10, 'host' => '127.0.0.1', 'port' => 11211)
            );
            $this->cache = new \Telelab\Cache\Cache($config);
        }
        
        return $this->cache;
    }
    
    public function testSetCache()
    {
        $this->getCache()->setCache('test', 'content');
    }
    
    
    public function testGetCache()
    {
        $this->assert->string($this->getCache()->getCache('test'))
                     ->isEqualTo('content');
    }
}