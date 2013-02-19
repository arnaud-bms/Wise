<?php
namespace Telelab\FrontController\tests\units;

require_once __DIR__.'/bootstrap.php';

use mageekguy\atoum;

/**
 * Test  \Telelab\FrontController
 *
 * @author Guillaume Dievart <g.dievart@telemaque.fr>
 */
class FrontController extends atoum\test
{
    public function testRun()
    {
        $this->assert->exception(function(){
                                \Telelab\FrontController\FrontController::run('/Example truc');
                            })
                     ->isInstanceOf('\Telelab\Router\RouterException')
                     ->hasCode(404);

        \Telelab\FrontController\FrontController::run('/Example/home truc truc');
        $this->assert->string(\Telelab\FrontController\FrontController::getResponse());
    }
}