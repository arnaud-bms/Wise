<?php
namespace Telelab\Cache\Driver;

use Telelab\Cache\Driver\Driver;

/**
 * Driver Cache with memcached
 *
 * @author gdievart <g.dievart@telemaque.fr>
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
     * Init memcached driver
     *
     * @param array $config
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
     * @return string Content, if the request's cache exists
     */
    public function getCache($uniqId)
    {
        return $this->_memcache->get($uniqId);
    }


    /**
     * Set cache
     *
     * @param string $uniqId
     * @param string $content
     */
    public function setCache($uniqId, $content)
    {
        $this->_memcache->add($uniqId, $content, false, $this->_ttl);
    }
}
