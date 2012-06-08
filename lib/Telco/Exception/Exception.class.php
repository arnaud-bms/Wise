<?php
namespace Telco\Exception;

/**
 * Exception
 *
 * @author gdievart
 */
class Exception extends \Exception
{
    
    /**
     * Format message exception
     * 
     * @return string message formatted
     */
    public function __toString() 
    {
        return 'Exception [' . $this->getCode() . '] ' .$this->getMessage() . ' ' .
               'on file ' . $this->getFile() . ' (' . $this->getLine() . ')';
    }
}
