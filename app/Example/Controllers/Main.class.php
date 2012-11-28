<?php
namespace Example\Controllers;

use Example\ExampleController;
use Telelab\FrontController\FrontController;

/**
 * Description of Main
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Main extends ExampleController
{

    /**
     * Method test
     *
     * @param string $var
     * @param string $var
     * @return array $response
     */
    public function index()
    {
        $response['page'] = 'TOTO';

        $testRepository = $this->getRepository('\Example\Models\TestRepository');
        $test = $testRepository->findByName('Guillaume');
        $response['rows'] = array($test);

        // Set property format for plugin Format
        FrontController::setProperty('format', 'json');

        return $response;
    }


    /**
     * Method redirect
     *
     * @param string $var
     */
    public function generateIndex($var, $var2)
    {
        FrontController::setProperty('format', 'xml');
        FrontController::setProperty('generate', 'home');
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

        FrontController::setProperty('format', 'xml');
        FrontController::setProperty('generate', 'list');

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
