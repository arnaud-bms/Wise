<?php
namespace Telelab\Cache\Driver;

use Telelab\Component\Component;

/**
 * Driver: Abstract cache driver
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class Driver extends Component
{
    abstract public function getCache($uniqId);

    abstract public function setCache($uniqId, $content, $ttl = null);
}