<?php
namespace Wise\Conf\tests\units;

use atoum;

/**
 * Tests on the conf component
 *
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Conf extends atoum
{
    public function testLoadPhpConf()
    {
        file_put_contents();
    }
    
    public function testLoadJsonConf()
    {
        
    }
    
    public function testLoadIniConf()
    {
        
    }
    
    protected function testLoadConf($file)
    {
        $this->assert->boolean(\Wise\Conf\Conf::load($file))
            ->isTrue();
    }
    
    
    public function testMergeConf()
    {
        
    }
    
    public function testGetConf()
    {
        
    }
    
    public function testSetConf()
    {
        
    }
    
    public function testRewriteConf()
    {
        
    }
}