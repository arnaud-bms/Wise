<?php
namespace Plugin;

use Telelab\FrontController\FrontController;
use Telelab\Plugin\Plugin;
use Telelab\Str\Str;

/**
 * Plugin Cache, use Telelab\Cache
 * This plugins must be call before and after the action of the controller
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
     * Write content's request if exists to stdout
     */
    public function precall()
    {
        $cacheId = FrontController::getRouteId()
                 . '.' . Str::url(FrontController::getRouteName(), '.');
        if ($content = $this->_cache->getCache($cacheId)) {
            FrontController::interruptRequest();
            echo $content;
        }
    }


    /**
     * Write the content's request to the cache system
     */
    public function postcall()
    {
        $cacheId = FrontController::getRouteId()
                 . '.' . Str::url(FrontController::getRouteName(), '.');
        $this->_cache->setCache($cacheId, FrontController::getResponse());
    }
}
