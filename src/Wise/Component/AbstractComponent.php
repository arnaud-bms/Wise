<?php
namespace Wise\Component;

use Wise\Conf\Conf;

/**
 * Class \Wise\Component\AbstractComponent
 *
 * This class is the base of all components. It loads default configuration and check
 * the required fields for instanciate the component
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class AbstractComponent
{

    /**
     * Extract the component configuration
     *
     * @param  string $class  The default class
     * @param  array  $config Configuration passed to construct of the component
     * @return mixed  Component configuration
     */
    protected static function getComponentConfig($class, $config)
    {
        if ($config === null) {
            $configName = substr($class, strlen('Wise\\'));
            $configName = substr($configName, 0, strpos($configName, '\\'));
            $configName = strtolower($configName);

            if ($componentConfig = Conf::get($configName)) {
                $config = $componentConfig;
            }
        }

        return $config;
    }

    /**
     * Check if the required fields are presents
     *
     * @param  array              $config
     * @throws ComponentException If a field does not exist
     */
    protected static function checkRequiredFields($requiredFields, $config)
    {
        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $config)) {
                throw new Exception("The field '$field' is required", 0);
            }
        }
    }
}
