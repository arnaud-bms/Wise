<?php
namespace Plugin;

use Wise\FrontController\FrontController;
use Wise\Plugin\Plugin;
use Wise\Str\Str;

/**
 * Plugin Cache, use Wise\Cache
 * This plugins must be call before and after the action of the controller
 *
 * @author gdievart
 */
class Cache extends Plugin
{
    /**
     * @var Cache Ref to \Wise\Cache\Cache
     */
    private $cache = null;

    /**
     * Init Plugin Cache
     */
    public function init($config) {
        $this->cache = new \Wise\Cache\Cache();
        parent::init($config);
    }

    /**
     * Write content's request if exists to stdout
     */
    public function precall()
    {
        $cacheId = FrontController::getRouteId()
                 . '.' . Str::url(FrontController::getRouteName(), '.');
        if ($content = $this->cache->getCache($cacheId)) {
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
        $this->cache->setCache($cacheId, FrontController::getResponse());
    }
}
