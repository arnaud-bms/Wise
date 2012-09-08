<?php
namespace Plugin;

use Telco\FrontController\FrontController;
use Telco\Plugin\Plugin;
use Telco\Str\Str;

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
    public function _init()
    {
        $this->_cache = new \Telco\Cache\Cache();
    }
    
    /**
     * Method call on precall
     */
    public function precall()
    {
        if($content = $this->_cache->getCache(FrontController::getRouteId())) {
            FrontController::interruptRequest();
            echo $content;
        }
    }
    
    
    /**
     * Method call on postcall
     */
    public function postcall()
    {
        $cacheId = FrontController::getRouteId().'.'.Str::url(FrontController::getRouteName(), '.');
        $this->_cache->setCache($cacheId, FrontController::getResponse());
    }
}
