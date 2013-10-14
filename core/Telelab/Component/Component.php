<?php
namespace Telelab\Component;

/**
 * Component: Base of the dynamic component
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class Component extends AbstractComponent
{

    /**
     * Construct Component
     *
     * @param mixed $config
     */
    final public function __construct($config = null)
    {
        $config = self::getComponentConfig(get_called_class(), $config);
        if ($config !== null && is_array($config) && isset($this->requiredFields)) {
            self::checkRequiredFields($this->requiredFields, $config);
        }

        $this->init($config);
    }


    /**
     * Init component
     *
     * @param mixed $config
     */
    protected function init($config)
    {
echo;
    }
}
