<?php
namespace Plugin;

use Telelab\FrontController\FrontController;
use Telelab\Globals\Globals;
use Telelab\Plugin\Plugin;

/**
 * Plugin generate
 * This plugins is used for generated content's request
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
     * Write result of the request in file
     */
    public function postcall()
    {
        if ($alias = Globals::get('generate')) {
            $generate = new \Telelab\Generate\Generate();
            $generate->generateFile($alias, FrontController::getResponse());
        }
    }
}
