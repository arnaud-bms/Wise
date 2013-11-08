<?php
namespace Telelab\Component;

/**
 * ComponentStatic: Base of static components
 *
 * @author gdievart <dievartg@gmail.com>
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
        if ($config !== null && is_array($config) && isset($class::$requiredFields)) {
            self::checkRequiredFields($class::$requiredFields, $config);
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
