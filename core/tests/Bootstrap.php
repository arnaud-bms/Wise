<?php
namespace Telco\Bootstrap\tests\units;

require_once __DIR__.'/atoum/mageekguy.atoum.phar';
require_once __DIR__.'/config.php';

use mageekguy\atoum;

/**
 * Test  \Telco\Bootstrap
 * 
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Bootstrap extends atoum\test
{
    public function testRun()
    {   
        $this->assert->exception(function(){
                                \Telco\Bootstrap\Bootstrap::run('/Test truc');
                            })
                     ->isInstanceOf('\Telco\Router\RouterException')
                     ->hasCode(404);
        
        \Telco\Bootstrap\Bootstrap::run('/Test truc truc');
        $this->assert->string(\Telco\Bootstrap\Bootstrap::getResponse());
    }
}