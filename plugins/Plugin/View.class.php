<?php
namespace Plugin;

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
     * @var Cache Ref to \Telelab\Cache\Cache
     */
    private $_view = null;

    /**
     * Init Plugin Cache
     */
    public function _init($config)
    {
        $this->_view = new \Telelab\View\View();
    }

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
            $this->_view->setDataList(FrontController::getResponse());
            FrontController::setResponse(
                $this->_view->fetch(Conf::getConfig('view.default_template'))
            );
        }
    }
}
