<?php
namespace Example\Controllers;

use Example\ExampleController;
use Telelab\Globals\Globals;

/**
 * Basic controller
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Basic extends ExampleController
{

    /**
     * Simple route
     *
     * @return array $response
     */
    public function index()
    {
        Globals::set('format', 'html');

        $response['page'] = 'basic/simple_route.tpl';

        return $response;
    }


    public function repository()
    {
        $response['page'] = 'TOTO';

        $testRepository = $this->getRepository('\Example\Models\TestRepository');
        $test = $testRepository->findByName('Guillaume');
        $response['rows'] = array($test);

        // Set property format for plugin Format
        Globals::set('format', 'json');

        return $response;
    }


    /**
     * Method redirect
     *
     * @param string $var
     */
    public function generateIndex($var, $var2)
    {
        Globals::set('format', 'json');
        Globals::set('generate', 'home');
        return $this->index($var, $var2);
    }


    /**
     * Example of generating list
     */
    public function generateList()
    {
        $testRepository = $this->getRepository('Example\Models\TestRepository');

        $stmt = $testRepository->select('*');
        $response['rows'] = $stmt->fetchAll();

        Globals::set('format', 'json');
        Globals::set('generate', 'list');

        return $response;
    }


    /**
     * Test redis
     */
    public function testRedis()
    {
        $redis = new \Telelab\Redis\Redis();

        $redis->set('test', 'values');

        echo $redis->get('test')."\n";
    }


    /**
     * Method redirect
     *
     * @param string $var
     */
    public function redirect()
    {
        $this->_redirect('/Example/home titi chuc');
    }
}
