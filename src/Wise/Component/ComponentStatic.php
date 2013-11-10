<?php
namespace Wise\Component;

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
        if ($config !== null && is_array($config) && isset(static::$requiredFields)) {
            self::checkRequiredFields(static::$requiredFields, $config);
        }

        self::init($config);
    }

    /**
     * This method is called after __construct
     *
     * @param mixed $config
     */
    protected static function init($config)
    {

    }
}
