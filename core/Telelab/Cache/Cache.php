<?php
namespace Telelab\Cache;

use Telelab\Component\Component;

/**
 * Cache: Set and get cache
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Cache extends Component
{

    /**
     * @var CacheDriver Driver used by cache system
     */
    protected $driver;

    /**
     * @var boolean Enable Cache
     */
    protected $enable;

    /**
     * @var array Required fields
     */
    protected $requiredFields = array(
        'enable',
        'driver'
    );


    /**
     * Init Cache
     *
     * @param array $config
     * @throws CacheException If driver does'nt exists
     */
    protected function init($config)
    {
        switch($config['driver']) {
            case 'file':
                $driver = 'Telelab\Cache\Driver\File';
                break;
            case 'memcache':
                $driver = 'Telelab\Cache\Driver\Memcache';
                break;
            default:
                throw new CacheException("Driver '{$config['driver']}' does'nt exists", 400);
        }

        $driverConfig = isset($config[$config['driver']]) ? $config[$config['driver']] : null;
        $this->driver = new $driver($driverConfig);

        $this->enable = (boolean)$config['enable'];
    }


    /**
     * Retrieve cache
     *
     * @param string $uniqId Request id
     * @return string Content's request
     */
    public function getCache($uniqId)
    {
        if ($this->enable) {
            return $this->driver->getCache($uniqId);
        }

        return false;
    }


    /**
     * Set content to Cache
     *
     * @param string $uniqId
     * @param string $content
     * @param int $ttl
     */
    public function setCache($uniqId, $content, $ttl = null)
    {
        if ($this->enable) {
            $this->driver->setCache($uniqId, $content, $ttl);
        }
    }
}
