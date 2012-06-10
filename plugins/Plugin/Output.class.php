<?php
namespace Plugin;

use Telco\Bootstrap\Bootstrap;
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
    public function precall() { }
    
    
    /**
     * Method call on postcall
     */
    public function postcall()
    {
        echo Bootstrap::getResponse();
    }
}
