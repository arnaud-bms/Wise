<?php
namespace Telelab\View;

use Telelab\Component\Component;
use Telelab\Html\Html;

/**
 * ViewHelper: Helper that generate view component (styles & scripts & meta? html) and handle it
 *
 * @author fmanas <f.manas@telemaque.fr>
 */
class ViewHelper extends Component
{
    /**
     * Include style
     *
     * @param string|array $style
     */
    public static function includeStyle($style = null)
    {
        if (is_array($style)) {
            $options = array('rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'all', 'title' => null, 'href' => null);
            $options = array_merge($options, $style);
            $options['href'] = (preg_match('/^(\/|http)/', $options['href']) ? '' : '/css/').$options['href'];
            echo '<link'.Html::tagOptions($options).' />'."\n";
        } else {
            echo '<link rel="stylesheet" type="text/css" href="'.(preg_match('/^(\/|http)/', $style) ? '' : '/css/').$style.'" media="all" />'."\n";
        }
    }

    /**
     * Include script
     *
     * @param string|array $script
     */
    public static function includeScript($script = null)
    {
        if (is_array($script)) {
            $options = array('type' => 'text/javascript', 'title' => null, 'src' => null);
            $options = array_merge($options, $script);
            $options['href'] = (preg_match('/^(\/|http)/', $options['src']) ? '' : '/js/').$options['src'];
            echo '<script'.Html::tagOptions($options).' />'."\n";
        } else {
            echo '<script type="text/javascript" src="'.(preg_match('/^(\/|http)/', $script) ? '' : '/js/').$script.'"></script>'."\n";
        }
    }
}