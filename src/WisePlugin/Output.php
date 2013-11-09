<?php
namespace Plugin;

use Wise\Plugin\Plugin;

/**
 * Plugin output, the plugin is used to write on stdout
 *
 * @author gdievart
 */
class Output extends Plugin
{

    /**
     * Method call on precall
     */
    public function precall()
    {

    }


    /**
     * Method call on postcall
     */
    public function postcall()
    {
        $response = \Wise\Dispatcher\Dispatcher::getResponse();
        if (is_array($response)) {
            print_r($response);
        } elseif(is_object($response)) {
            var_dump($response);
        } else {
            echo $response;
        }
    }
}
