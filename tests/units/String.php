<?php
namespace Wise\Str\tests\units;

use atoum;

/**
 * Test  \Wise\Str
 *
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class String extends atoum
{
    public function testLower()
    {
        $this->assert->string(\Wise\String\String::lower('STRING'))
                     ->isEqualTo('string');
    }

    public function testUpper()
    {
        $this->assert->string(\Wise\String\String::upper('string'))
                     ->isEqualTo('STRING');
    }

    public function testUcFirst()
    {
        $this->assert->string(\Wise\String\String::ucfirst('string'))
                     ->isEqualTo('String');
    }

    public function testUrl()
    {
        $this->assert->string(\Wise\String\String::url('Unit testsé'))
                     ->isEqualTo('unit-testse');
    }

    public function testRemoveAccent()
    {
        $this->assert->string(\Wise\String\String::removeAccent('Unit testsé'))
                     ->isEqualTo('Unit testse');
        
        $this->assert->string(\Wise\String\String::removeAccent(utf8_decode('Unit testsé')))
                     ->isEqualTo('Unit testse');
    }

    public function testHash()
    {
        $this->assert->string(\Wise\String\String::hash('Unit test'))
                     ->hasLength(32);
    }

    public function testNormalizePhoneNumber()
    {
        $this->assert->integer(\Wise\String\String::normalizePhoneNumber('0612345678'))
                     ->isEqualTo(33612345678);

        $this->assert->integer(\Wise\String\String::normalizePhoneNumber('06.12.34.56.78'))
                     ->isEqualTo(33612345678);

        $this->assert->integer(\Wise\String\String::normalizePhoneNumber('+33612345678'))
                     ->isEqualTo(33612345678);
    }

    public function testLiteralize()
    {
        $this->assert->boolean(\Wise\String\String::literalize('true'))
                     ->isTrue();

        $this->assert->boolean(\Wise\String\String::literalize('on'))
                     ->isTrue();

        $this->assert->boolean(\Wise\String\String::literalize('+'))
                     ->isTrue();

        $this->assert->boolean(\Wise\String\String::literalize('yes'))
                     ->isTrue();

        $this->assert->boolean(\Wise\String\String::literalize('false'))
                     ->isFalse();

        $this->assert->boolean(\Wise\String\String::literalize('off'))
                     ->isFalse();

        $this->assert->boolean(\Wise\String\String::literalize('-'))
                     ->isFalse();

        $this->assert->boolean(\Wise\String\String::literalize('no'))
                     ->isFalse();

        $this->assert->variable(\Wise\String\String::literalize('null'))
                     ->isNull();

        $this->assert->variable(\Wise\String\String::literalize('~'))
                     ->isNull();

        $this->assert->variable(\Wise\String\String::literalize(''))
                     ->isNull();
        
        $this->assert->integer(\Wise\String\String::literalize('20'));
        
        $this->assert->float(\Wise\String\String::literalize('20.5'));
    }

    public function testCamelcase()
    {
        $this->assert->string(\Wise\String\String::camelCase('bonjour_test'))
                     ->isEqualTo('BonjourTest');
    }
    
    public function testIsUtf8()
    {
        $this->assert->boolean(\Wise\String\String::isUtf8('bonjour é'))
                     ->isTrue();
        
        $this->assert->boolean(\Wise\String\String::isUtf8(utf8_decode('bonjour é')))
                     ->isFalse();
    }
    
    
    public function testEscapeOnce()
    {
        $this->assert->string(\Wise\String\String::escapeOnce('&'))
                     ->isEqualTo('&amp;');
        
        $this->assert->string(\Wise\String\String::escapeOnce('"'))
                     ->isEqualTo('&quot;');
    }
    
    
    public function testFixDoubleEscape()
    {
        $this->assert->string(\Wise\String\String::fixDoubleEscape('&amp;eacute;'))
                     ->isEqualTo('&eacute;');
    }
    
    
    public function testCamelcaseToUnderscores()
    {
        $this->assert->string(\Wise\String\String::camelcaseToUnderscores('CeciEstUnTest'))
                     ->isEqualTo('ceci_est_un_test');
    }
    
    
    public function testCheckAddslashes()
    {
        $this->assert->string(\Wise\String\String::checkAddslashes('C\'est un test'))
                     ->isEqualTo('C\\\'est un test');
    }
    
    
    public function testMbUnserialize()
    {
        $this->assert->array(\Wise\String\String::mbUnserialize(serialize(array('tést'))))
                     ->contains('tést');
    }
}