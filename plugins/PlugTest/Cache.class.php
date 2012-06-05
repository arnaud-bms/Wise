<?php
namespace PlugTest;

use Tlc\Bootstrap\Bootstrap;
use Tlc\Plugin\Plugin;
use Tlc\Conf\Conf;

/**
 * Description of Cache
 *
 * @author gdievart
 */
class Cache extends Plugin
{
    /**
     * @var Cache 
     */
    private $_cache = null;
    
    /**
     * Method call on precall
     */
    public function precall()
    {
        $this->_initCache();
        if($content = $this->_cache->getCache(Bootstrap::getRouteId())) {
            Bootstrap::interruptRequest();
            Bootstrap::setResponse($content);
            echo $content;
        }
    }
    
    
    /**
     * Method call on postcall
     */
    public function postcall()
    {
        $this->_initCache();
        $this->_cache->setCache(Bootstrap::getRouteId(), Bootstrap::getResponse());
    }
    
    
    /**
     * Init Cache
     */
    private function _initCache()
    {
        if($this->_cache === null) {
            $this->_cache = new \Tlc\Cache\Cache(Conf::getConfig('cache'));
        }
    }
}
