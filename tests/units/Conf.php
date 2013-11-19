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
    public function _testLoadPhpConf()
    {
        file_put_contents();
    }
    
    public function _testLoadJsonConf()
    {
        
    }
    
    public function _testLoadIniConf()
    {
        
    }
    
    protected function _testLoadConf($file)
    {
        $this->assert->boolean(\Wise\Conf\Conf::load($file))
            ->isTrue();
    }
    
    
    public function _testMergeConf()
    {
        
    }
    
    public function _testGetConf()
    {
        
    }
    
    public function _testSetConf()
    {
        
    }
    
    public function _testRewriteConf()
    {
        
    }
}