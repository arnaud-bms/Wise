<?php
namespace Telelab\Component;

use Telelab\Conf\Conf;

/**
 * AbstractComponent: Base class of components
 * This class load configuration component
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class AbstractComponent
{

    /**
     * Extract Component configuration
     *
     * @param string $class Class called
     * @param array $config Configuration passed to construct of the component
     * @return mixed Component configuration
     */
    protected static function _getComponentConfig($class, $config)
    {
        if ($config === null) {
            $configName = substr($class, strlen('Telelab\\'));
            $configName = substr($configName, 0, strpos($configName, '\\'));
            $configName = strtolower($configName);

            if ($componentConfig = Conf::getConfig($configName)) {
                $config = $componentConfig;
            }
        }

        return $config;
    }


    /**
     * Check is required fields is present
     *
     * @param array $config
     * @throws ComponentException If the field does'nt exists
     */
    protected static function _checkRequiredFields($requiredFields, $config)
    {
        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $config)) {
                throw new ComponentException("The field '$field' is required", 400);
            }
        }
    }
}
