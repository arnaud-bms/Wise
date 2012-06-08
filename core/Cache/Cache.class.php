<?php
namespace Tlc\Cache;

use Tlc\Component\Component;

/**
 * Description of Conf
 *
 * @author gdievart
 */
class Cache extends Component 
{
    
    /**
     * @var CacheEngine 
     */
    protected $_engine;
    
    /**
     * @var boolean Enable Cache 
     */
    protected $_enable;
    
    /**
     * @var array Required fields 
     */
    protected $_requiredFields = array(
        'enable',
        'engine'
    );
    
    
    /**
     * Init Cache
     * 
     * @param array $config 
     */
    protected function _init($config)
    {
        $class = 'Tlc\Cache\Engine\\' . ucfirst($config['engine']);
        $this->_engine = new $class($config[$config['engine']]);
        
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
            return $this->_engine->getCache($uniqId);
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
            $this->_engine->setCache($uniqId, $content);
        }
    }
}
