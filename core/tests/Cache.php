<?php
namespace Telco\Cache\tests\units;

require_once __DIR__.'/atoum/mageekguy.atoum.phar';
require_once __DIR__.'/config.php';

use mageekguy\atoum;

/**
 * Test  \Telco\Autoloader
 * 
 * @author Guillaume Dievart <dievartg@gmail.com>
 */
class Cache extends atoum\test
{
    public function testSetCache()
    {   
        $cache = new \Telco\Cache\Cache();
        $cache->setCache('test', 'content');
        $this->assert->string($cache->getCache('test'))
                     ->isEqualTo('content');
    }
}