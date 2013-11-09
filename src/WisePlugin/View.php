<?php
namespace Plugin;

use Wise\Globals\Globals;
use Wise\Plugin\Plugin;
use Wise\Conf\Conf;

/**
 * Plugin View, use Wise\View
 *
 * @author gdievart
 */
class View extends Plugin
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
        if (is_array(\Wise\Dispatcher\Dispatcher::getResponse())) {
            $responseFormat = Globals::get('format');
            if ($responseFormat !== null && $responseFormat !== 'html') {
                $format = new \Wise\Format\Format();
                \Wise\Dispatcher\Dispatcher::setResponse(
                    $format->formatData(
                        $responseFormat,
                        \Wise\Dispatcher\Dispatcher::getResponse()
                    )
                );
            } else {
                $view = new \Wise\View\View();
                $view->setDataList(\Wise\Dispatcher\Dispatcher::getResponse());
                \Wise\Dispatcher\Dispatcher::setResponse(
                    $view->fetch(Conf::getConfig('view.default_template'))
                );
            }
        }
    }
}
