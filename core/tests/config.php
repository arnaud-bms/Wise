<?php
/**
 * Default configuration for UnitTests 
 */

use Telelab\Autoloader\Autoloader;
use Telelab\Conf\Conf;

define('ROOT_DIR', __DIR__.'/../../');
require_once ROOT_DIR.'/core/components/Autoloader/Autoloader.class.php';
spl_autoload_register(array('\Telelab\Autoloader\Autoloader', 'loadClass'));
Autoloader::setAlias(array(
    'Telelab'       => ROOT_DIR.'core/components',
    'Example'     => ROOT_DIR.'app/Example',
    'Plugin'      => ROOT_DIR.'plugins/Plugin'
));

Conf::loadConfig(ROOT_DIR.'etc/telelab.ini');
Conf::mergeConfig(ROOT_DIR.'etc/routing.ini');