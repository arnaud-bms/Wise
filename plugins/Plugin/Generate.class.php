<?php
namespace Plugin;

use Telelab\FrontController\FrontController;
use Telelab\Plugin\Plugin;

/**
 * Plugin generate, use to generate files
 *
 * @author gdievart
 */
class Generate extends Plugin
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
        if ($alias = FrontController::getProperty('generate')) {
            $generate = new \Telelab\Generate\Generate();
            $generate->generateFile($alias, FrontController::getResponse());
        }
    }
}
