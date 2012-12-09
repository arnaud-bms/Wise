<?php
namespace Telelab\Component;

/**
 * ComponentStatic: Base of static components
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class ComponentStatic extends AbstractComponent
{

    /**
     * Construct ComponentStatic
     *
     * @param mixed $config
     */
    public static function init($config = null)
    {
        $class = get_called_class();
        $config = self::_getComponentConfig($class, $config);
        if ($config !== null && is_array($config) && isset($class::$_requiredFields)) {
            self::_checkRequiredFields($class::$_requiredFields, $config);
        }

        $class::_init($config);
    }


    /**
     * Init component
     *
     * @param mixed $config
     */
    protected static function _init($config)
    {

    }
}
