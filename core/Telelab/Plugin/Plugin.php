<?php
namespace Telelab\Plugin;

use Telelab\Component\Component;

/**
 * Abstract class Plugin
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class Plugin extends Component
{
    /**
     * Method call on precall
     */
    abstract public function precall();
    
    /**
     * Method call on postcall
     */
    abstract public function postcall();
}
