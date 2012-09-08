<?php
namespace Telco\FrontController\tests\units;

require_once __DIR__.'/atoum/mageekguy.atoum.phar';
require_once __DIR__.'/config.php';

use mageekguy\atoum;

/**
 * Test  \Telco\FrontController
 * 
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class FrontController extends atoum\test
{
    public function testRun()
    {   
        $this->assert->exception(function(){
                                \Telco\FrontController\FrontController::run('/Example truc');
                            })
                     ->isInstanceOf('\Telco\Router\RouterException')
                     ->hasCode(404);
        
        \Telco\FrontController\FrontController::run('/Example/home truc truc');
        $this->assert->string(\Telco\FrontController\FrontController::getResponse());
    }
}