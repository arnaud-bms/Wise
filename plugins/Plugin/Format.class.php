<?php
namespace Plugin;

use Telco\FrontController\FrontController;
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
        if($responseFormat = FrontController::getProperty('format')) 
        {
            $format = new \Telco\Format\Format();
            FrontController::setResponse(
                    $format->formatData($responseFormat, 
                    FrontController::getResponse()));
        }
    }
}
