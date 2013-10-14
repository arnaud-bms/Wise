<?php
namespace Telelab\Format\tests\units;

use atoum;

/**
 * Test  \Telelab\Format
 *
 * @author Guillaume Dievart <g.dievart@telemaque.fr>
 */
class Format extends atoum
{

    private $_format;

    private $_data;


    public function beforeTestMethod($testMethod)
    {
        $this->_format = new \Telelab\Format\Format();
        $this->_data  = array(0 => array('child1'), 'key_one' => 'value_one', 'key_two' => 'value_two');
    }


    public function testJson()
    {
        $this->assert->string($this->_format->formatData('json', $this->_data))
                     ->isEqualTo(json_encode($this->_data));
    }


    public function testXML()
    {
        $stdout    = '<?xml version="1.0" encoding="utf-8"?>'."\n".
                     '<xml><node><node>child1</node></node><key_one>value_one</key_one><key_two>value_two</key_two></xml>'."\n";

        $this->assert->string($this->_format->formatData('xml', $this->_data))
                     ->isEqualTo($stdout);
    }


    public function testSerialize()
    {
        $this->assert->string($this->_format->formatData('serialize', $this->_data))
                     ->isEqualTo(serialize($this->_data));
    }
    
    public function testCSV()
    {
        $this->assert->string($this->_format->formatData('csv', $this->_data))
                     ->isEqualTo('');
    }
    
    public function testException()
    {
        $myObject = $this;
        $this->assert->exception(function() use($myObject) { $myObject->_format->formatData('csvs', $myObject->_data); })
                     ->hasCode(0);
    }
}