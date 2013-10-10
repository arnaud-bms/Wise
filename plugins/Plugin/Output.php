<?php
namespace Plugin;

use Telelab\FrontController\FrontController;
use Telelab\Plugin\Plugin;

/**
 * Plugin output, the plugin is used to write on stdout
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
