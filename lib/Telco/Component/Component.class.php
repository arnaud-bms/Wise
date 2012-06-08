<?php
namespace Telco\Component;

/**
 * Class base 
 *
 * @author gdievart
 */
abstract class Component 
{
    
    /**
     * Construct Component
     * 
     * @param type $config 
     */
    public function __construct($config = null) 
    {
        if($config !== null && is_array($config) && isset($this->_requiredFields)) {
            $this->_checkRequiredFields($config);
        }
        
        $this->_init($config);
    }
    
    
    /**
     * Check is required fields is present
     * 
     * @param array $config
     */
    private function _checkRequiredFields($config) 
    {
        foreach($this->_requiredFields as $field) {
            if(!array_key_exists($field, $config)) {
                throw new ComponentException("The field '$field' is required", 400);
            }
        }
    }
    
    
    /**
     * Init component
     * 
     * @param type $config 
     */
    protected function _init($config) { }
}
