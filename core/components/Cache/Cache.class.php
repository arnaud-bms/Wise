<?php
namespace Telco\Cache;

use Telco\Component\Component;

/**
 * Cache component
 *
 * @author gdievart
 */
class Cache extends Component 
{
    
    /**
     * @var CacheDriver 
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
     */
    protected function _init($config)
    {
        switch($config['driver']) {
            case 'file':
                $driver = 'Telco\Cache\Driver\File';
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
     * @param string $uniqId
     * @return string $content
     */
    public function getCache($uniqId)
    {
        if($this->_enable) {
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
        if($this->_enable) {
            $this->_driver->setCache($uniqId, $content);
        }
    }
}
