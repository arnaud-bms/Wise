<?php
/**
 * FrontController of the application
 *
 * @author gdievart <dievartg@gmail.com>
 */
use Telelab\Conf\Conf;
use Telelab\FrontController\FrontController;
use Telelab\Globals\Globals;
use Telelab\Logger\Logger;

define('ROOT_DIR', realpath(__DIR__.'/..').'/');
require ROOT_DIR.'vendor/autoload.php';

// Load the default configuration
Conf::loadConfig(ROOT_DIR.'app/etc/app.php');

// Load the file which contains routes
Conf::mergeConfig(ROOT_DIR.'app/etc/routing.php');

// Set exception handler if exists
if ($handlerConfig = Conf::getConfig('exception_handler')) {
    set_exception_handler(array($handlerConfig['class'], $handlerConfig['method']));
}

// Set error handler if exists
if ($errorConfig = Conf::getConfig('error_handler')) {
    set_error_handler(array($errorConfig['class'], $errorConfig['method']));
}

Globals::initStatic();
Logger::initStatic();
FrontController::initStatic();
FrontController::run();
