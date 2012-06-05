<?php
namespace PlugTest;

use Tlc\Bootstrap\Bootstrap;
use Tlc\Plugin\Plugin;
use Tlc\Conf\Conf;

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
        $generate = new \Tlc\Generate\Generate(Conf::getConfig('generate'));
        $generate->generateFile(
                Bootstrap::getRouteName() . ':' . Bootstrap::getFormat(),
                Bootstrap::getResponse());
    }
}
