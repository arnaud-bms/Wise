<?php
namespace Telelab\Str\tests\units;

require_once __DIR__.'/bootstrap.php';

use mageekguy\atoum;

/**
 * Test  \Telelab\Str
 *
 * @author Guillaume Dievart <g.dievart@telemaque.fr>
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

    public function testRemoveAccent()
    {
        $this->assert->string(\Telelab\Str\Str::removeAccent('Unit testsé'))
                     ->isEqualTo('Unit testse');
    }

    public function testHash()
    {
        $this->assert->string(\Telelab\Str\Str::hash('Unit test'))
                     ->hasLength(32);
    }

    public function testNormalizePhoneNumber()
    {
        $this->assert->integer(\Telelab\Str\Str::normalizePhoneNumber('0612345678'))
                     ->isEqualTo(33612345678);

        $this->assert->integer(\Telelab\Str\Str::normalizePhoneNumber('06.12.34.56.78'))
                     ->isEqualTo(33612345678);

        $this->assert->integer(\Telelab\Str\Str::normalizePhoneNumber('+33612345678'))
                     ->isEqualTo(33612345678);
    }

    public function testLiteralize()
    {
        $this->assert->boolean(\Telelab\Str\Str::literalize('true'))
                     ->isTrue();

        $this->assert->boolean(\Telelab\Str\Str::literalize('on'))
                     ->isTrue();

        $this->assert->boolean(\Telelab\Str\Str::literalize('+'))
                     ->isTrue();

        $this->assert->boolean(\Telelab\Str\Str::literalize('yes'))
                     ->isTrue();

        $this->assert->boolean(\Telelab\Str\Str::literalize('false'))
                     ->isFalse();

        $this->assert->boolean(\Telelab\Str\Str::literalize('off'))
                     ->isFalse();

        $this->assert->boolean(\Telelab\Str\Str::literalize('-'))
                     ->isFalse();

        $this->assert->boolean(\Telelab\Str\Str::literalize('no'))
                     ->isFalse();

        $this->assert->variable(\Telelab\Str\Str::literalize('null'))
                     ->isNull();

        $this->assert->variable(\Telelab\Str\Str::literalize('~'))
                     ->isNull();

        $this->assert->variable(\Telelab\Str\Str::literalize(''))
                     ->isNull();
    }

    public function testCamelcase()
    {
        $this->assert->string(\Telelab\Str\Str::camelCase('bonjour_test'))
                     ->isEqualTo('BonjourTest');
    }
}