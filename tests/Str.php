<?php
namespace Wise\Str\tests\units;

use atoum;

/**
 * Test  \Wise\Str
 *
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Str extends atoum
{
    public function testLower()
    {
        $this->assert->string(\Wise\Str\Str::lower('STRING'))
                     ->isEqualTo('string');
    }

    public function testUpper()
    {
        $this->assert->string(\Wise\Str\Str::upper('string'))
                     ->isEqualTo('STRING');
    }

    public function testUcFirst()
    {
        $this->assert->string(\Wise\Str\Str::ucfirst('string'))
                     ->isEqualTo('String');
    }

    public function testUrl()
    {
        $this->assert->string(\Wise\Str\Str::url('Unit testsé'))
                     ->isEqualTo('unit-testse');
    }

    public function testRemoveAccent()
    {
        $this->assert->string(\Wise\Str\Str::removeAccent('Unit testsé'))
                     ->isEqualTo('Unit testse');
        
        $this->assert->string(\Wise\Str\Str::removeAccent(utf8_decode('Unit testsé')))
                     ->isEqualTo('Unit testse');
    }

    public function testHash()
    {
        $this->assert->string(\Wise\Str\Str::hash('Unit test'))
                     ->hasLength(32);
    }

    public function testNormalizePhoneNumber()
    {
        $this->assert->integer(\Wise\Str\Str::normalizePhoneNumber('0612345678'))
                     ->isEqualTo(33612345678);

        $this->assert->integer(\Wise\Str\Str::normalizePhoneNumber('06.12.34.56.78'))
                     ->isEqualTo(33612345678);

        $this->assert->integer(\Wise\Str\Str::normalizePhoneNumber('+33612345678'))
                     ->isEqualTo(33612345678);
    }

    public function testLiteralize()
    {
        $this->assert->boolean(\Wise\Str\Str::literalize('true'))
                     ->isTrue();

        $this->assert->boolean(\Wise\Str\Str::literalize('on'))
                     ->isTrue();

        $this->assert->boolean(\Wise\Str\Str::literalize('+'))
                     ->isTrue();

        $this->assert->boolean(\Wise\Str\Str::literalize('yes'))
                     ->isTrue();

        $this->assert->boolean(\Wise\Str\Str::literalize('false'))
                     ->isFalse();

        $this->assert->boolean(\Wise\Str\Str::literalize('off'))
                     ->isFalse();

        $this->assert->boolean(\Wise\Str\Str::literalize('-'))
                     ->isFalse();

        $this->assert->boolean(\Wise\Str\Str::literalize('no'))
                     ->isFalse();

        $this->assert->variable(\Wise\Str\Str::literalize('null'))
                     ->isNull();

        $this->assert->variable(\Wise\Str\Str::literalize('~'))
                     ->isNull();

        $this->assert->variable(\Wise\Str\Str::literalize(''))
                     ->isNull();
        
        $this->assert->integer(\Wise\Str\Str::literalize('20'));
        
        $this->assert->float(\Wise\Str\Str::literalize('20.5'));
    }

    public function testCamelcase()
    {
        $this->assert->string(\Wise\Str\Str::camelCase('bonjour_test'))
                     ->isEqualTo('BonjourTest');
    }
    
    public function testIsUtf8()
    {
        $this->assert->boolean(\Wise\Str\Str::isUtf8('bonjour é'))
                     ->isTrue();
        
        $this->assert->boolean(\Wise\Str\Str::isUtf8(utf8_decode('bonjour é')))
                     ->isFalse();
    }
    
    
    public function testEscapeOnce()
    {
        $this->assert->string(\Wise\Str\Str::escapeOnce('&'))
                     ->isEqualTo('&amp;');
        
        $this->assert->string(\Wise\Str\Str::escapeOnce('"'))
                     ->isEqualTo('&quot;');
    }
    
    
    public function testFixDoubleEscape()
    {
        $this->assert->string(\Wise\Str\Str::fixDoubleEscape('&amp;eacute;'))
                     ->isEqualTo('&eacute;');
    }
    
    
    public function testCamelcaseToUnderscores()
    {
        $this->assert->string(\Wise\Str\Str::camelcaseToUnderscores('CeciEstUnTest'))
                     ->isEqualTo('ceci_est_un_test');
    }
    
    
    public function testCheckAddslashes()
    {
        $this->assert->string(\Wise\Str\Str::checkAddslashes('C\'est un test'))
                     ->isEqualTo('C\\\'est un test');
    }
    
    
    public function testMbUnserialize()
    {
        $this->assert->array(\Wise\Str\Str::mbUnserialize(serialize(array('tést'))))
                     ->contains('tést');
    }
}