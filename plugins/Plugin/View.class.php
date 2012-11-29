<?php
namespace Plugin;

use Telelab\Globals\Globals;
use Telelab\FrontController\FrontController;
use Telelab\Plugin\Plugin;
use Telelab\Conf\Conf;

/**
 * Plugin View, use Telelab\View
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
        if (is_array(FrontController::getResponse())) {
            if ($responseFormat = Globals::get('format')) {
                if ($responseFormat !== 'html') {
                    $format = new \Telelab\Format\Format();
                    FrontController::setResponse(
                        $format->formatData(
                            $responseFormat,
                            FrontController::getResponse()
                        )
                    );
                } else {
                    $view = new \Telelab\View\View();
                    $view->setDataList(FrontController::getResponse());
                    FrontController::setResponse(
                        $view->fetch(Conf::getConfig('view.default_template'))
                    );
                }
            }
        }
    }
}
