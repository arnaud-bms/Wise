<?php
namespace Plugin;

use Telelab\Plugin\Plugin;
use Telelab\Globals\Globals;

/**
 * Plugin Session, use Telelab\Session
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
        Globals::set('session', new \Telelab\Session\Session());
        
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
