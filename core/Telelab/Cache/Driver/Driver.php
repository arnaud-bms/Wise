<?php
namespace Wise\Cache\Driver;

use Wise\Component\Component;

/**
 * Driver: Abstract cache driver
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Driver extends Component
{
    abstract public function getCache($uniqId);

    abstract public function setCache($uniqId, $content, $ttl = null);
}
