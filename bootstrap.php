<?php
/**
 * Description of bootstrap
 *
 * @author gdievart
 */

define('ROOT_DIR', __DIR__ . '/');

require_once ROOT_DIR . '/lib/Tlc/Autoloader/Autoloader.class.php';
spl_autoload_register(array('\Tlc\Autoloader\Autoloader', 'registerAutoload'));

\Tlc\Conf\Conf::loadConfig(ROOT_DIR . 'etc/tlc.ini');

if($handlerConfig = \Tlc\Conf\Conf::getConfig('exception_handler')) {
    set_exception_handler(array($handlerConfig['class'], $handlerConfig['method']));
}

if($errorConfig = \Tlc\Conf\Conf::getConfig('error_handler')) {
    set_error_handler(array($errorConfig['class'], $errorConfig['method']));
}

\Tlc\Bootstrap\Bootstrap::run();