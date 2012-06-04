<?php
/**
 * Description of bootstrap
 *
 * @author gdievart
 */

use Tlc\Autoloader\Autoloader;
use Tlc\Conf\Conf;
use Tlc\Bootstrap\Bootstrap;

define('ROOT_DIR', __DIR__ . '/');

require_once ROOT_DIR . '/lib/Tlc/Autoloader/Autoloader.class.php';
spl_autoload_register(array('Tlc\Autoloader\Autoloader', 'loadClass'));

Autoloader::setAlias(array(
    'Tlc'           => ROOT_DIR . 'lib',
    'Test'          => ROOT_DIR . 'app',
    'PlugTest'      => ROOT_DIR . 'plugins'
));

Conf::loadConfig(ROOT_DIR . 'etc/tlc.ini');
Conf::mergeConfig(ROOT_DIR . 'etc/routing.ini');

if($handlerConfig = Conf::getConfig('exception_handler')) {
    set_exception_handler(array($handlerConfig['class'], $handlerConfig['method']));
}

if($errorConfig = Conf::getConfig('error_handler')) {
    set_error_handler(array($errorConfig['class'], $errorConfig['method']));
}

echo Bootstrap::run();