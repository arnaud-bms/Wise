<?php
namespace Telelab\Component;

use Telelab\Conf\Conf;

/**
 * Class base component
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class AbstractComponent
{

    /**
     * Extract Component configuration
     *
     * @param string $class Class called
     * @param array $config
     * @return array
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
