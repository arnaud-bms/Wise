<?php
namespace Plugin;

use Telelab\FrontController\FrontController;
use Telelab\Plugin\Plugin;
use Telelab\Str\Str;

/**
 * Plugin Cache, use Telelab\Cache
 *
 * @author gdievart
 */
class Cache extends Plugin
{
    /**
     * @var Cache Ref to \Telelab\Cache\Cache
     */
    private $_cache = null;

    /**
     * Init Plugin Cache
     */
    public function _init($config)
    {
        $this->_cache = new \Telelab\Cache\Cache();
    }

    /**
     * Method call on precall
     */
    public function precall()
    {
        if ($content = $this->_cache->getCache(FrontController::getRouteId())) {
            FrontController::interruptRequest();
            echo $content;
        }
    }


    /**
     * Method call on postcall
     */
    public function postcall()
    {
        $cacheId = FrontController::getRouteId()
                 . '.' . Str::url(FrontController::getRouteName(), '.');
        $this->_cache->setCache($cacheId, FrontController::getResponse());
    }
}
