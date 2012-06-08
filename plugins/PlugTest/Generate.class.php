<?php
namespace PlugTest;

use Telco\Bootstrap\Bootstrap;
use Telco\Plugin\Plugin;
use Telco\Conf\Conf;

/**
 * Description of Cache
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
        $generate = new \Telco\Generate\Generate(Conf::getConfig('generate'));
        $generate->generateFile(
                Bootstrap::getRouteName() . ':' . Bootstrap::getFormat(),
                Bootstrap::getResponse());
    }
}
