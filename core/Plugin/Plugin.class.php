<?php
namespace Tlc\Plugin;

use Tlc\Component\Component;

/**
 * Abstract class Plugin
 *
 * @author gdievart
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
