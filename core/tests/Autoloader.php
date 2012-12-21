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

    /**
     * 2 Tests on the method LoadClass
     */
    public function testLoadClass()
    {
        $this->assert->exception(function(){ new \Telelab\Unknow(); })
                     ->isInstanceOf('\Telelab\Autoloader\AutoloaderException');

        $this->assert->object(new \Telelab\CodeGen\CodeGen())
                     ->isInstanceOf('\Telelab\CodeGen\CodeGen');
    }
}