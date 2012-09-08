<?php
namespace Plugin;

use Telco\FrontController\FrontController;
use Telco\Plugin\Plugin;
use Telco\Conf\Conf;

/**
 * Plugin View, use Telco\View
 *
 * @author gdievart
 */
class View extends Plugin
{
    /**
     * @var Cache Ref to \Telco\Cache\Cache
     */
    private $_view = null;
    
    /**
     * Init Plugin Cache
     */
    public function _init($config)
    {
        $this->_view = new \Telco\View\View();
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
        if(is_array(FrontController::getResponse())) {
            $this->_view->setDataList(FrontController::getResponse());
            FrontController::setResponse($this->_view->fetch(Conf::getConfig('view.default_template')));
        }
    }
}
