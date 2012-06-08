<?php
/**
 * Description of bootstrap
 *
 * @author gdievart
 */

use Telco\Autoloader\Autoloader;
use Telco\Conf\Conf;
use Telco\Bootstrap\Bootstrap;

define('ROOT_DIR', __DIR__ . '/');

require_once ROOT_DIR . '/lib/Telco/Autoloader/Autoloader.class.php';
spl_autoload_register(array('Telco\Autoloader\Autoloader', 'loadClass'));

Autoloader::setAlias(array(
    'Telco'         => ROOT_DIR . 'lib',
    'Test'          => ROOT_DIR . 'app',
    'PlugTest'      => ROOT_DIR . 'plugins'
));

Conf::loadConfig(ROOT_DIR . 'etc/telco.ini');
Conf::mergeConfig(ROOT_DIR . 'etc/routing.ini');

if($handlerConfig = Conf::getConfig('exception_handler')) {
    set_exception_handler(array($handlerConfig['class'], $handlerConfig['method']));
}

if($errorConfig = Conf::getConfig('error_handler')) {
    set_error_handler(array($errorConfig['class'], $errorConfig['method']));
}

Bootstrap::init(Conf::getConfig('bootstrap'));
Bootstrap::run();