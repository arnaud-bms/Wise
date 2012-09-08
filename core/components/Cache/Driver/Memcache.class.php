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
     * @var array Required fields 
     */
    protected $_requiredFields = array(
        'host',
        'port'
    );
    
    /**
     * Init File driver
     * 
     * @param array $config 
     */
    public function __construct($config)
    {
        foreach($this->_requiredFields as $field) {
            if(!array_key_exists($field, $config)) {
                throw new CacheException("The field '$field' is required on drivre Mem", 400);
            }
        }
        
        $this->_memcache = new \Memcache();
        $this->_memcache->connect($config['host'], $config['port']);
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
        $this->_memcache->add($uniqId, $content);
    }
}
