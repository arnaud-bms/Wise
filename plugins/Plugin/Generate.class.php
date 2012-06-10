<?php
namespace Plugin;

use Telco\Bootstrap\Bootstrap;
use Telco\Plugin\Plugin;

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
    public function precall() { }
    
    
    /**
     * Method call on postcall
     */
    public function postcall()
    {
        $generate = new \Telco\Generate\Generate();
        $generate->generateFile(
                Bootstrap::getRouteName().':'.Bootstrap::getFormat(),
                Bootstrap::getResponse());
    }
}
