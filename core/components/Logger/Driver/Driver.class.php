<?php
namespace Telelab\Logger\Driver;

use Telelab\Component\Component;

/**
 * Driver logger
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Driver extends Component
{
    abstract public function log($message, $level);
}
