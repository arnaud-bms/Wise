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
        $this->_data  = array('key_one' => 'value_one', 'key_two' => 'value_two');
    }


    public function testJson()
    {
        $this->assert->string($this->_format->formatData('json', $this->_data))
                     ->isEqualTo(json_encode($this->_data));
    }


    public function testXML()
    {
        $stdout    = '<?xml version="1.0" encoding="utf-8"?>'."\n".
                     '<xml><key_one>value_one</key_one><key_two>value_two</key_two></xml>'."\n";

        $this->assert->string($this->_format->formatData('xml', $this->_data))
                     ->isEqualTo($stdout);
    }


    public function testSerialize()
    {
        $this->assert->string($this->_format->formatData('serialize', $this->_data))
                     ->isEqualTo(serialize($this->_data));
    }
}