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
        $config = self::_getComponentConfig(get_called_class(), $config);
        if ($config !== null && is_array($config) && isset($this->_requiredFields)) {
            self::_checkRequiredFields($this->_requiredFields, $config);
        }

        $this->_init($config);
    }


    /**
     * Init component
     *
     * @param mixed $config
     */
    protected function _init($config)
    {

    }
}
