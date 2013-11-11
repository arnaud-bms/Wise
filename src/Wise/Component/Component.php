<?php
namespace Wise\Component;

/**
 * Class \Wise\Component\Component
 *
 * This class must be extended by all dynamic components
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Component extends AbstractComponent
{

    /**
     * Component construct is a final method
     *
     * @param mixed $config
     */
    final public function __construct($config = null)
    {
        $config = self::getComponentConfig(get_called_class(), $config);
        if (isset($this->requiredFields)) {
            self::checkRequiredFields($this->requiredFields, (array)$config);
        }

        $this->init($config);
    }

    /**
     * This method is called after __construct
     *
     * @param mixed $config
     */
    protected function init($config)
    {
        return;
    }
}
