<?php
namespace Plugin;

use Telco\Bootstrap\Bootstrap;
use Telco\Plugin\Plugin;

/**
 * Format data
 *
 * @author gdievart
 */
class Format extends Plugin
{
    
    /**
     * Method call on precall
     */
    public function precall() { }
    
    
    /**
     * Method call on postcall
     */
    public function postcall()
    {
        $format = new \Telco\Format\Format();
        Bootstrap::setResponse(
                $format->formatData(Bootstrap::getFormat(), 
                Bootstrap::getResponse()));
    }
}
