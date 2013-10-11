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
    public static function initStatic($config = null)
    {
        $class = get_called_class();
        $config = self::getComponentConfig($class, $config);
        if ($config !== null && is_array($config) && isset($class::$_requiredFields)) {
            self::checkRequiredFields($class::$_requiredFields, $config);
        }
        
        self::init($config);
    }


    /**
     * Init component
     *
     * @param mixed $config
     */
    protected static function init($config)
    {

    }
}
