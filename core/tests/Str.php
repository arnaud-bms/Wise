<?php
namespace Telelab\Str\tests\units;

require_once __DIR__.'/atoum/mageekguy.atoum.phar';
require_once __DIR__.'/config.php';

use mageekguy\atoum;

/**
 * Test  \Telelab\Str
 * 
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Str extends atoum\test
{
    public function testLower()
    {   
        $this->assert->string(\Telelab\Str\Str::lower('STRING'))
                     ->isEqualTo('string');
    }
    
    
    public function testUpper()
    {
        $this->assert->string(\Telelab\Str\Str::upper('string'))
                     ->isEqualTo('STRING');
    }
    
    
    public function testUcFirst()
    {
        $this->assert->string(\Telelab\Str\Str::ucfirst('string'))
                     ->isEqualTo('String');
    }
    
    
    public function testUrl()
    {
        $this->assert->string(\Telelab\Str\Str::url('Unit testsé'))
                     ->isEqualTo('unit-testse');
    }
}