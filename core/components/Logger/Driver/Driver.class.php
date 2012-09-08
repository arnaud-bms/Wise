<?php
namespace Telco\Logger\Driver;

use Telco\Component\Component;

/**
 * Driver logger
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Driver extends Component
{   
    abstract public function log($message, $level);
}
