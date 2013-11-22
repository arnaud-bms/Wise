<?php
namespace Wise\Exception;

/**
 * Class: \Wise\Exception\Exception
 * 
 * This class must be to extended by all component exception
 *
 * @author gdievart <dievartg@gmail.com>
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
        return get_class($this).' '
              . '['.$this->getCode().'] '
              . $this->getMessage().' '
              . 'in file '.$this->getFile().' '
              . 'on line '.$this->getLine();
    }
}
