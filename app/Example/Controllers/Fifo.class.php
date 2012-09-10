<?php
namespace Example\Controllers;

use Example\ExampleController;

/**
 * Description of Fifo
 *
 * @author gdievart
 */
class Fifo extends ExampleController
{
    public function _init($config)
    {
        $this->repo = new \Example\Models\FifoRepository($config);
    }

    public function __call($method, $argv)
    {
        return call_user_func_array(array($this->repo, $method), $argv);
    }
}