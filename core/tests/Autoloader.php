<?php
namespace Telco\Autoloader\tests\units;

require_once __DIR__.'/atoum/mageekguy.atoum.phar';
require_once __DIR__.'/config.php';

use mageekguy\atoum;

/**
 * Test  \Telco\Autoloader
 * 
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Autoloader extends atoum\test
{
    public function testLoadClass()
    {   
        $this->assert->when(function(){
                                new \Telco\Unknow();
                            })
                     ->error()
                     ->exists();
    }
}