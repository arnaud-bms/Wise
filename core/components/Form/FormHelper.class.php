<?php
namespace Telelab\Form;

use Telelab\Globals\Globals;
use Telelab\View\ViewHelper;

/**
 * FormHelper: Helper that generate form components (html) and handle it
 *
 * @author fmanas <f.manas@telemaque.fr>
 */
class FormHelper
{
    /**
     * Generate captcha HTML code
     *
     * @param array $options Array
     */
    public static function generateCaptcha($options = array())
    {
        $default = array(
            'message' => 'Par mesure de sécurité,<br />Merci de cliquer sur #DET#<strong class="selected">#OBJ#</strong> dans la liste : *', 
            'return' => false,
            'style' => 'form/captcha.css',
            'script' => 'form/jquery.captcha.js'
        );

        $options = array_merge($default, $options);
        $captcha = '';

        ViewHelper::includeStyle($options['style']);
        ViewHelper::includeScript($options['script']);

        $elements_picture = empty($options['picture']) ? '/img/icons/captcha/fruits.jpg' : $options['picture'];

        $elements         = empty($options['items']) ? array('cerise' => 'la', 'poire' => 'la', 'fraises' => 'les', 'pomme' => 'la', 'prunes' => 'les') : $options['items'];
        $elements_values  = array_keys($elements);
        $elements_shuffle = $elements_values;
        shuffle($elements_shuffle);

        $size = empty($options['size']) ? 57 : $options['size'];

        $rand = mt_rand(0, (sizeof($elements) - 1));

        $element = array($elements[$elements_shuffle[$rand]].($elements[$elements_shuffle[$rand]] == "l'" ? '' : ' '), $elements_shuffle[$rand]);

        $captcha .= '<label for="captcha">'.str_replace(array('#DET#', '#OBJ#'), $element, $options['message']).'</label>';

        $captcha .= '<input type="hidden" id="captcha" name="captcha" data-type="captcha" data-required="true" />';


        $elements_codes = array();
        for($i = 0 ; $i < sizeof($elements_shuffle); $i++) {
            $elements_codes[$i] = mt_rand();

            $key_shuffle = $elements_shuffle[$i];
            $key = array_search($key_shuffle, $elements_values);
            //error_log($key_shuffle .' => '.$key);

            $captcha .= '<div class="captcha_item" style="background: url('.$elements_picture.') -'.($key * $size).'px top no-repeat; width: '.$size.'px; height: '.$size.'px; cursor: pointer;" data-value="'.$elements_codes[$i].'"></div>';
        }

        Globals::get('session')->captcha = $elements_codes[$rand];

        if ($options['return'] === true) {
            return $captcha;
        } else {
            echo $captcha;
        }
    }

    /**
     * Check captcha code
     *
     * @param array $options Array
     */
    public static function isValidCaptcha($code = null)
    {
        if (Globals::get('session')->captcha) {
            if ($code == Globals::get('session')->captcha && $code != '') {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
}
