<?php
namespace Telelab\Autoloader\tests\units;

require_once __DIR__.'/config.php';

use mageekguy\atoum;

/**
 * Test  \Telelab\Autoloader
 *
 * @author Guillaume Dievart <g.dievart@telemaque.fr>
 */
class Autoloader extends atoum\test
{

    public function testLoadClass()
    {
        $this->assert->when(function(){
                                new \Telelab\Unknow();
                            })
                     ->error()
                     ->exists();
    }
}