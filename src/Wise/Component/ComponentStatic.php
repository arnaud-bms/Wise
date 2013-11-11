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
        $config = self::getComponentConfig(get_called_class(), $config);
        if (isset(static::$requiredFields)) {
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
