<?php
namespace Plugin;

use Telco\FrontController\FrontController;
use Telco\Plugin\Plugin;

/**
 * Plugin output, use to write on stdout
 *
 * @author gdievart
 */
class Output extends Plugin
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
        echo FrontController::getResponse();
    }
}
