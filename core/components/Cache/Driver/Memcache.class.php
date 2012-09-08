<?php
namespace Telco\Cache\Driver;

use Telco\Cache\Driver\Driver;

/**
 * Driver Cache with memcached
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Memcache extends Driver
{
    
    /**
     * @var MemCache
     */
    protected $_memcache;
    
    /**
     * @var int ttl
     */
    protected $_ttl;
    
    /**
     * @var array Required fields 
     */
    protected $_requiredFields = array(
        'host',
        'port',
        'ttl'
    );
    
    /**
     * 
     * @param type $config
     */
    protected function _init($config)
    {
        $this->_memcache = new \Memcache();
        $this->_memcache->connect($config['host'], $config['port']);
        $this->_ttl = $config['ttl'];
    }
    
    /**
     * Retrieve valid cache
     * 
     * @param type $uniqId 
     */
    public function getCache($uniqId)
    {
        return $this->_memcache->get($uniqId);
    }
    
    
    /**
     * Set cache
     * 
     * @param type $uniqId
     * @param type $content 
     */
    public function setCache($uniqId, $content)
    {
        $this->_memcache->add($uniqId, $content, $this->_ttl);
    }
}
