<?php
/**
 * FrontController of the application
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */

use Telelab\Autoloader\Autoloader;
use Telelab\Conf\Conf;
use Telelab\FrontController\FrontController;
use Telelab\Globals\Globals;
use Telelab\Logger\Logger;

define('ROOT_DIR', __DIR__.'/../');

require_once ROOT_DIR.'/core/components/Autoloader/Autoloader.class.php';
spl_autoload_register(array('Telelab\Autoloader\Autoloader', 'loadClass'));

Autoloader::setAlias(
    array(
        'Telelab'         => ROOT_DIR.'core/components',
        'Plugin'        => ROOT_DIR.'plugins/Plugin'
    )
);

// Load the default configuration
Conf::loadConfig(ROOT_DIR.'app/etc/app.ini');

// Load the file which contains routes
Conf::mergeConfig(ROOT_DIR.'app/etc/routing.ini');

// Set exception handler if exists
if ($handlerConfig = Conf::getConfig('exception_handler')) {
    set_exception_handler(
        array($handlerConfig['class'],
        $handlerConfig['method'])
    );
}

// Set error handler if exists
if ($errorConfig = Conf::getConfig('error_handler')) {
    set_error_handler(array($errorConfig['class'], $errorConfig['method']));
}

Globals::init();
Logger::init();
FrontController::init();
FrontController::run();
