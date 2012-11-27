<?php
namespace Example\Controllers;

use Example\ExampleController;
use Telco\FrontController\FrontController;

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
        $response['rows'] = array('name' => 'value');

        $response['page'] = 'TOTO';

        // Set property format for plugin Format
        FrontController::setProperty('format', 'html');

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
     *
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
        $redis = new \Telco\Redis\Redis();

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
