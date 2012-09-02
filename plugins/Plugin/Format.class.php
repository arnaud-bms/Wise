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
        if($responseFormat = Bootstrap::getProperty('format')) 
        {
            $format = new \Telco\Format\Format();
            Bootstrap::setResponse(
                    $format->formatData($responseFormat, 
                    Bootstrap::getResponse()));
        }
    }
}
