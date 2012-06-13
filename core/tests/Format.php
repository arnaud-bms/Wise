<?php
namespace Telco\Format\tests\units;

require_once __DIR__.'/atoum/mageekguy.atoum.phar';
require_once __DIR__.'/config.php';

use mageekguy\atoum;

/**
 * Test  \Telco\Format
 * 
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Format extends atoum\test
{
    
    private $_format;
    
    
    public function setUp()
    {
        $this->_format = new \Telco\Format\Format();
    }
    
    
    public function testJson()
    {
        $arrayTest = array('key_one' => 'value_one', 'key_two' => 'value_two');
        $this->assert->string($this->_format->formatData('json', $arrayTest))
                     ->isEqualTo(json_encode($arrayTest));
    }
    
    
    public function testXML()
    {
        $format    = new \Telco\Format\Format();
        $arrayTest = array('key_one' => 'value_one', 'key_two' => 'value_two');
        $stdout    = '<?xml version="1.0" encoding="utf-8"?>'."\n".
                     '<xml><key_one>value_one</key_one><key_two>value_two</key_two></xml>'."\n";
        
        $this->assert->string($format->formatData('xml', $arrayTest))
                     ->isEqualTo($stdout);
    }
    
    
    public function testSerialize()
    {
        $format    = new \Telco\Format\Format();
        $arrayTest = array('key_one' => 'value_one', 'key_two' => 'value_two');
        
        $this->assert->string($format->formatData('serialize', $arrayTest))
                     ->isEqualTo(serialize($arrayTest));
    }
}