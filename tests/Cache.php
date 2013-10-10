<?php
namespace Telelab\Cache\tests\units;

use atoum;

/**
 * Test  \Telelab\Autoloader
 *
 * @author Guillaume Dievart <g.dievart@telemaque.fr>
 */
class Cache extends atoum
{
    public function testSetCache()
    {
        $cache = new \Telelab\Cache\Cache();
        $cache->setCache('test', 'content');
        $this->assert->string($cache->getCache('test'))
                     ->isEqualTo('content');
    }
}