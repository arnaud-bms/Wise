<?php
namespace Wise\Cache\Driver;

use Wise\Cache\Driver\Driver;

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
    protected $memcache;

    /**
     * @var int ttl
     */
    protected $ttl;

    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'host',
        'port',
        'ttl'
    );

    /**
     * Init memcached driver
     *
     * @param array $config
     */
    protected function init($config)
    {
        $this->memcache = new \Memcache();
        $this->memcache->connect($config['host'], $config['port']);
        $this->ttl = $config['ttl'];
    }

    /**
     * Retrieve valid cache
     *
     * @param  type   $uniqId
     * @return string Content, if the request's cache exists
     */
    public function getCache($uniqId)
    {
        return $this->memcache->get($uniqId);
    }

    /**
     * Set cache
     *
     * @param string $uniqId
     * @param string $content
     */
    public function setCache($uniqId, $content, $ttl = null)
    {
        $ttl = $ttl === null ? $this->ttl : $ttl;
        $this->memcache->set($uniqId, $content, false, $ttl);
    }
}