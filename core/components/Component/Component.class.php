<?php
namespace Telco\Component;

/**
 * Class base 
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Component extends AbstractComponent
{
    
    /**
     * Construct Component
     * 
     * @param type $config 
     */
    final public function __construct($config = null) 
    {
        $class = get_called_class();
        $config = self::_getComponentConfig($class, $config);
        
        if($config !== null && is_array($config) && isset($this->_requiredFields)) {
            self::_checkRequiredFields($this->_requiredFields, $config);
        }
        
        $this->_init($config);
    }
    
    
    /**
     * Init component
     * 
     * @param type $config 
     */
    protected function _init($config) { }
}
