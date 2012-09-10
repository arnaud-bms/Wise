<?php
namespace Example\Plugins;

use Telco\Plugin\Plugin;

/**
 * Plugin PID, create pid file
 *
 * @author gdievart
 */
class PID extends Plugin
{
    
    /**
     * Method call on precall
     */
    public function precall()
    {
        echo "CREATE PID FILE\n";
    }
    
    
    /**
     * Method call on postcall
     */
    public function postcall()
    {
        echo "UNLINK PID FILE\n";
    }
}
