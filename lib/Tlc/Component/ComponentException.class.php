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
        return '[' . $this->getCode() . '] ' .$this->getMessage() . ' ' .
               'on file ' . $this->getFile() . ' (' . $this->getLine() . ')';
    }
}
