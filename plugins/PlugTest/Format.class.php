<?php
namespace PlugTest;

use Tlc\Bootstrap\Bootstrap;
use Tlc\Plugin\Plugin;
use Tlc\Conf\Conf;

/**
 * Description of Cache
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
        $format = new \Tlc\Format\Format();
        Bootstrap::setResponse(
                $format->formatData(Bootstrap::getFormat(), 
                Bootstrap::getResponse()));
    }
}
