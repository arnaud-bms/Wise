<?php
namespace Wise\Cache;

use Wise\Component\Component;
use Wise\Cache\Exception;

/**
 * Class  \Wise\Cache\Cache
 * 
 * This class is the interface of cache system
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Cache extends Component
{

    /**
     * Driver loaded
     * 
     * @var Cache\Driver
     */
    protected $driver;

    /**
     * Enable or disable the cache system
     * 
     * @var boolean
     */
    protected $enable;

    /**
     * {@inherit}
     */
    protected $requiredFields = array(
        'enable',
        'driver'
    );

    /**
     * {@inherit}
     * @throws \Wise\Cache\Exception if the driver does not exist or if does not implement \Wise\Cache\Driver\Cache
     */
    protected function init($config)
    {
        $classname = 'Wise\Cache\Driver\\'.ucfirst((string) $config['driver']);
        if(!class_exists($classname, true) || !in_array('Wise\Cache\Driver\Cache', class_implements($classname, true))) {
            throw new Exception('The driver "'.$classname.'" is not valid', 0);
        }
        
        $driverConfig = !empty($config[$config['driver']]) ? $config[$config['driver']] : null;
        $driver = new \ReflectionClass($classname);
        $this->driver = $driver->newInstance($driverConfig);
        $this->enable = (boolean) $config['enable'];
    }

    /**
     * @see \Wise\Cache\Driver\Cache
     */
    public function get($key)
    {
        if ($this->enable) {
            return $this->driver->get($key);
        }

        return false;
    }

    /**
     * @see \Wise\Cache\Driver\Cache
     */
    public function set($key, $content, $ttl = null)
    {
        if ($this->enable) {
            $this->driver->set($key, $content, $ttl);
        }
    }
    
    
    /**
     * @see \Wise\Cache\Driver\Cache
     */
    public function delete($key)
    {
        if ($this->enable) {
            $this->driver->delete($key);
        }
    }
    
    /**
     * @see \Wise\Cache\Driver\Cache
     */
    public function flush()
    {
        if ($this->enable) {
            $this->driver->flush();
        }
    }
    
    /**
     * @see \Wise\Cache\Driver\Cache
     */
    public function decrement($key, $value = 1)
    {
        if ($this->enable) {
            $this->driver->decrement($key, $value);
        }
    }
    
    /**
     * @see \Wise\Cache\Driver\Cache
     */
    public function increment($key, $value = 1)
    {
        if ($this->enable) {
            $this->driver->increment($key, $value);
        }
    }
}
