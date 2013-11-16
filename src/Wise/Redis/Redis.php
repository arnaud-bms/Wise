<?php
namespace Wise\Redis;

use Wise\Component\Component;

/**
 * Connector to redis
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Redis extends Component
{
    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'host',
    );

    /**
     * @var handle Ref to Redis
     */
    protected $redis;

    /**
     * Open connection with redis
     *
     * @param array $config
     */
    protected function init($config)
    {
        $this->redis = new \Redis();

        $port    = isset($config['port']) ? $config['port'] : null;
        $timeout = isset($config['timeout']) ? $config['timeout'] : null;
        $this->redis->connect($config['host'], $port, $timeout);

        if (isset($config['prefix'])) {
            $this->setOption(\Redis::OPT_PREFIX, $config['prefix']);
        }
    }

    /**
     * Set option
     *
     * @param int  $name
     * @param type $value
     */
    public function setOption($name, $value)
    {
        return $this->redis->setOption($name, $value);
    }

    /**
     * Get option value
     *
     * @param  type   $name
     * @return string
     */
    public function getOption($name)
    {
        return $this->redis->getOption($name);
    }

    /**
     * @throw RedisException if connection is lost
     *
     * @return string +PONG
     */
    public function ping()
    {
        return $this->redis->ping();
    }

    /**
     * Set key with ttl in second
     *
     * @param  string  $key
     * @param  string  $value
     * @param  int     $ttl
     * @return boolean
     */
    public function setex($key, $value, $ttl)
    {
        return $this->redis->setex($key, $value, $ttl);
    }

    /**
     * Set key with ttl in millisecond
     *
     * @param  string  $key
     * @param  string  $value
     * @param  int     $ttl
     * @return boolean
     */
    public function psetex($key, $value, $ttl)
    {
        return $this->redis->psetex($key, $value, $ttl);
    }

    /**
     * Set key if not exists already
     *
     * @param  string  $key
     * @param  string  $value
     * @return boolean True if is set, or false if key exists already
     */
    public function setnx($key, $value)
    {
        return $this->redis->setnx($key, $value);
    }

    /**
     * Delete key from Redis
     *
     * @param (string|array) Key or list of keys to delete
     * @return int keys deleted
     */
    public function delete($key)
    {
        return $this->redis->delete((array) $key);
    }

    /**
     * Set data
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->redis->set($key, $value);
    }

    /**
     * Retrieve data
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }
    
    /**
     * Call the methods ont implemented
     * 
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args) 
    {
        return call_user_func_array(array($this->redis, $method));
    }

    /**
     * Close connection with Redis
     */
    public function __destruct()
    {
        $this->redis->close();
    }
}
