<?php
namespace PlugTest;

use Tlc\Bootstrap\Bootstrap;
use Tlc\Plugin\Plugin;

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
        echo __METHOD__ . "\n";
        echo Bootstrap::getResponse();
    }
}
