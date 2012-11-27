<?php
namespace Plugin;

use Telelab\FrontController\FrontController;
use Telelab\Plugin\Plugin;

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
    public function precall()
    {

    }


    /**
     * Method call on postcall
     */
    public function postcall()
    {
        if ($responseFormat = FrontController::getProperty('format')) {
            $format = new \Telelab\Format\Format();
            FrontController::setResponse(
                $format->formatData(
                    $responseFormat,
                    FrontController::getResponse()
                )
            );
        }
    }
}
