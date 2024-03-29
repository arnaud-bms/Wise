<?php
namespace Wise\Plugin;

use Wise\Component\Component;

/**
 * Abstract class Plugin
 *
 * @author gdievart <dievartg@gmail.com>
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
