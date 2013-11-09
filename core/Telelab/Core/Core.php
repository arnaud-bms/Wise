<?php
namespace Wise\Core;

/**
 * Class \Wise\Core
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Core extends \Wise\Component\ComponentStatic
{
    
    /**
     * {@inherit}
     */
    protected static function init($config)
    {
        if (!empty($config['exception_handler']) && is_callable($config['exception_handler'])) {
            set_exception_handler($config['exception_handler']);
        }
        
        if (!empty($config['error_handler']) && is_callable($config['error_handler'])) {
            set_exception_handler($config['error_handler']);
        }
    }
}

$config = \Wise\Conf\Conf::get('core') ?: array();
Core::initStatic($config);