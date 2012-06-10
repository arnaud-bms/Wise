<?php
namespace Plugin;

use Telco\Bootstrap\Bootstrap;
use Telco\Plugin\Plugin;
use Telco\Conf\Conf;

/**
 * Plugin Cache, use Telco\Cache
 *
 * @author gdievart
 */
class Cache extends Plugin
{
    /**
     * @var Cache Ref to \Telco\Cache\Cache
     */
    private $_cache = null;
    
    /**
     * Init Plugin Cache
     */
    public function __construct()
    {
        $this->_cache = new \Telco\Cache\Cache();
    }
    
    /**
     * Method call on precall
     */
    public function precall()
    {
        if($content = $this->_cache->getCache(Bootstrap::getRouteId())) {
            Bootstrap::interruptRequest();
            echo $content;
        }
    }
    
    
    /**
     * Method call on postcall
     */
    public function postcall()
    {
        $this->_cache->setCache(Bootstrap::getRouteId(), Bootstrap::getResponse());
    }
}
