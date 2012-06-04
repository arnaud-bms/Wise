<?php
namespace Tlc\Component;

/**
 * Description of ComponentException
 *
 * @author gdievart
 */
class ComponentException extends \Exception
{
    
    /**
     * Format message exception
     * 
     * @return string message formatted
     */
    public function __toString() 
    {
        $message = $this->getMessage() . '(' . $e->getCode() . ')';
        return $message;
    }
}
