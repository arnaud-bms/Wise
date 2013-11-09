<?php
namespace Wise\Cache\Driver;

/**
 * Class \Wise\Cache\Driver\Cache
 *
 * This cache system stores the data on the memcached server
 * Datas store in memcached are not persistent
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Memcache extends \Wise\Component\Component implements \Wise\Cache\Driver\Cache
{
    /**
     * Reference to \Memcache instance
     *
     * @var MemCache
     */
    protected $memcache;

    /**
     * Time to left before the datas are deleted
     *
     * @var int
     */
    protected $ttl;

    /**
     * {@inherit}
     */
    protected $requiredFields = array(
        'host',
        'port',
        'ttl'
    );

    /**
     * {@inherit}
     */
    protected function init($config)
    {
        $this->memcache = new \Memcache();
        $this->memcache->connect($config['host'], $config['port']);
        $this->ttl = $config['ttl'];
    }

    /**
     * {@inherit}
     */
    public function get($key)
    {
        return $this->memcache->get($key);
    }

    /**
     * {@inherit}
     */
    public function set($key, $content, $ttl = null)
    {
        $ttl = $ttl === null ? $this->ttl : $ttl;

        return $this->memcache->set($key, $content, false, $ttl);
    }

    /**
     * {@inherit}
     */
    public function delete($key)
    {
        return $this->memcache->delete($key);
    }

    /**
     * {@inherit}
     */
    public function flush()
    {
        return $this->memcache->flush();
    }

    /**
     * {@inherit}
     */
    public function decrement($key, $value = 1)
    {
       return $this->memcache->decrement($key, $value);
    }

    /**
     * {@inherit}
     */
    public function increment($key, $value = 1)
    {
        return $this->decrement($key, -$value);
    }
}
