<?php
namespace Telelab\Cache;

use Telelab\Component\Component;

/**
 * Cache: Set and get cache
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Cache extends Component
{

    /**
     * @var CacheDriver Driver used by cache system
     */
    protected $_driver;

    /**
     * @var boolean Enable Cache
     */
    protected $_enable;

    /**
     * @var array Required fields
     */
    protected $_requiredFields = array(
        'enable',
        'driver'
    );


    /**
     * Init Cache
     *
     * @param array $config
     * @throws CacheException If driver does'nt exists
     */
    protected function _init($config)
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
        $this->_driver = new $driver($driverConfig);

        $this->_enable = (boolean)$config['enable'];
    }


    /**
     * Retrieve cache
     *
     * @param string $uniqId Request id
     * @return string Content's request
     */
    public function getCache($uniqId)
    {
        if ($this->_enable) {
            return $this->_driver->getCache($uniqId);
        }

        return false;
    }


    /**
     * Set content to Cache
     *
     * @param string $uniqId
     * @param string $content
     */
    public function setCache($uniqId, $content)
    {
        if ($this->_enable) {
            $this->_driver->setCache($uniqId, $content);
        }
    }
}
