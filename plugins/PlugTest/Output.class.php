<?php
namespace PlugTest;

use Telco\Bootstrap\Bootstrap;
use Telco\Plugin\Plugin;

/**
 * Description of Cache
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
