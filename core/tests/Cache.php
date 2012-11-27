<?php
namespace Telelab\Cache\tests\units;

require_once __DIR__.'/atoum/mageekguy.atoum.phar';
require_once __DIR__.'/config.php';

use mageekguy\atoum;

/**
 * Test  \Telelab\Autoloader
 * 
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Cache extends atoum\test
{
    public function testSetCache()
    {   
        $cache = new \Telelab\Cache\Cache();
        $cache->setCache('test', 'content');
        $this->assert->string($cache->getCache('test'))
                     ->isEqualTo('content');
    }
}