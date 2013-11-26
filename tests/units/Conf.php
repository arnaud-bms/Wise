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
    
    public function testLoadConf()
    {
        $config1 = array('test.foo' => 'bar');
        $config2 = array('test' => array('foo' => 'bar'));
        
        $this->array(\Wise\Conf\Conf::load($config1))->isIdenticalTo($config2);
        
        $this->string(\Wise\Conf\Conf::get('test.foo'))->isEqualTo('bar');
    }
    
    
    public function testMergeConf()
    {
        $config1 = array('test.foo' => 'bar');
        $config2 = array('test.foo' => 'over');
        $config3 = array('test' => array('foo' => 'bar'));
        $config4 = array('test' => array('foo' => 'over'));
        
        $this->array(\Wise\Conf\Conf::load($config1))->isIdenticalTo($config3);
        
        $this->array(\Wise\Conf\Conf::merge($config2))->isEqualTo($config4);
    }
    
    public function testGetConf()
    {
        $config1 = array('test.foo' => 'bar');
        $config2 = array('test' => array('foo' => 'bar'));
        
        $this->array(\Wise\Conf\Conf::load($config1))->isIdenticalTo($config2);
        
        $this->string(\Wise\Conf\Conf::get('test.foo'))->isEqualTo('bar');
        
        $this->array(\Wise\Conf\Conf::get('test'))->isIdenticalTo($config2['test']);
    }
    
    public function testSetConf()
    {
        $config1 = array('test.foo' => 'bar');
        $config2 = array('test' => array('foo' => 'bar'));
        
        $this->array(\Wise\Conf\Conf::load($config1))->isIdenticalTo($config2);
        
        $this->string(\Wise\Conf\Conf::get('test.foo'))->isEqualTo('bar');
        
        $this->boolean(\Wise\Conf\Conf::set('test.foo', 'over'))->isTrue();
        
        $this->string(\Wise\Conf\Conf::get('test.foo'))->isEqualTo('over');
    }
}