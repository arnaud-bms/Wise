<?php
/**
 * Bootstrap of application
 *
 * @author gdievart
 */

use Telco\Autoloader\Autoloader;
use Telco\Conf\Conf;
use Telco\Bootstrap\Bootstrap;

define('ROOT_DIR', __DIR__.'/');

require_once ROOT_DIR.'/core/components/Autoloader/Autoloader.class.php';
spl_autoload_register(array('Telco\Autoloader\Autoloader', 'loadClass'));

Autoloader::setAlias(array(
    'Telco'         => ROOT_DIR.'core/components',
    'Plugin'        => ROOT_DIR.'plugins/Plugin'
));

Conf::loadConfig(ROOT_DIR.'etc/telco.ini');
Conf::mergeConfig(ROOT_DIR.'etc/routing.ini');

if($handlerConfig = Conf::getConfig('exception_handler')) {
    set_exception_handler(array($handlerConfig['class'], $handlerConfig['method']));
}

if($errorConfig = Conf::getConfig('error_handler')) {
    set_error_handler(array($errorConfig['class'], $errorConfig['method']));
}

Bootstrap::init();
Bootstrap::run();