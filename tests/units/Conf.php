<?php
namespace Wise\Conf\tests\units;

use atoum;

/**
 * Class \Wise\Conf\tests\units\Conf
 * 
 * This class tests the Conf component
 *
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Conf extends atoum
{
    
    public function testLoadConf()
    {
        $this
            ->if($config1 = array('test.foo' => 'bar'))
            ->and($config2 = array('test' => array('foo' => 'bar')))
            ->then
                ->array(\Wise\Conf\Conf::load($config1))->isIdenticalTo($config2)
                ->string(\Wise\Conf\Conf::get('test.foo'))->isEqualTo('bar')
        ;
    }
    
    
    public function testMergeConf()
    {
        $this
            ->if($config1 = array('test.foo' => 'bar'))
            ->and($config2 = array('test.foo' => 'over'))
            ->and($config3 = array('test' => array('foo' => 'bar')))
            ->and($config4 = array('test' => array('foo' => 'over')))
            ->then
                ->array(\Wise\Conf\Conf::load($config1))->isIdenticalTo($config3)
                ->array(\Wise\Conf\Conf::merge($config2))->isEqualTo($config4)
        ;
    }
    
    public function testGetConf()
    {
        $this
            ->if($config1 = array('test.foo' => 'bar'))
            ->and($config2 = array('test' => array('foo' => 'bar')))
            ->then
                ->array(\Wise\Conf\Conf::load($config1))->isIdenticalTo($config2)
                ->string(\Wise\Conf\Conf::get('test.foo'))->isEqualTo('bar')
                ->array(\Wise\Conf\Conf::get('test'))->isIdenticalTo($config2['test'])
        ;
    }
    
    public function testSetConf()
    {
        $this
            ->if($config1 = array('test.foo' => 'bar'))
            ->and($config2 = array('test' => array('foo' => 'bar')))
            ->then
                ->array(\Wise\Conf\Conf::load($config1))->isIdenticalTo($config2)
                ->string(\Wise\Conf\Conf::get('test.foo'))->isEqualTo('bar')
                ->boolean(\Wise\Conf\Conf::set('test.foo', 'over'))->isTrue()
                ->string(\Wise\Conf\Conf::get('test.foo'))->isEqualTo('over')
        ;
    }
}