<?php
namespace Plugin;

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
        $cacheId = \Wise\Dispatcher\Dispatcher::getRouteId()
                 . '.' . Str::url(\Wise\Dispatcher\Dispatcher::getRouteName(), '.');
        if ($content = $this->cache->getCache($cacheId)) {
            \Wise\Dispatcher\Dispatcher::interruptRequest();
            echo $content;
        }
    }


    /**
     * Write the content's request to the cache system
     */
    public function postcall()
    {
        $cacheId = \Wise\Dispatcher\Dispatcher::getRouteId()
                 . '.' . Str::url(\Wise\Dispatcher\Dispatcher::getRouteName(), '.');
        $this->cache->setCache($cacheId, \Wise\Dispatcher\Dispatcher::getResponse());
    }
}
