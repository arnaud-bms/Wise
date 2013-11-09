<?php
namespace Plugin;

use Wise\Plugin\Plugin;
use Wise\Globals\Globals;

/**
 * Plugin Session, use Wise\Session
 *
 * @author gdievart
 */
class Session extends Plugin
{

    /**
     * Init Plugin Cache
     */
    public function init($config)
    {
        Globals::set('session', new \Wise\Session\Session());
        
        parent::init($config);
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

    }
}
