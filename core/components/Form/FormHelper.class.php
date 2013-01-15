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
     * Generate html tag
     *
     * @param array $options
     * @return string html
     */   
    public function createTag($options = array()) {
        $default = array('type' => 'input', 'label' => '', 'attributes' => array('name' => 'ipt'), 'value' => '', 'p' => false, 'p_class' => false);
        $options = array_merge($default, $options);

        $field = '';
        if($p_class != false) {
            $pclass = ' class="'.$p_class.'"';
        } else {
            $pclass="";
        }

        if ($p == true) {
            $field.='<p'.$pclass.'>';
        }

        $for = isset($options['attributes']["id"]) ? $options['attributes']['id'] : $options['attributes']['name'];

        if ($options['label'] != '')  {
            $field .= '<label id="label_'.$for.'" for="'.$for.'">'.$options['label'].'</label>';
        }

        switch ($options['type']) {
            case 'input':
                $field .= '<input ';
                foreach($options['attributes'] as $attr => $val){
                    $field .= $attr.'="'.$val.'" ';
                }

                $field .= 'value="'.$value.'" />';
            break;
            case 'textarea':
                /*
                - cols :    nombre de caractères affichés par ligne
                - rows :    détermine le nombre de lignes visibles dans la zone de texte
                - wrap :    Ses valeurs possibles sont : hard / off / soft
                                    détermine si les retours à la ligne se font automatiquement (hard / soft)
                                    ou si une scrollbar horizontale apparait en cas de dépassement (off)
                - disabled :    rend la zone de texte grisée et non modifiable
                - readonly :    rend la zone de texte non modifiable mais ne change pas son apparence
                */
                $field .= '<textarea ';
                foreach($options['attributes'] as $attr => $val) {
                    $field .= $attr.'="'.$val.'" ';
                }
                $field.=">".$value."</textarea>";
            break;
        }

        if ($p == true) {
            $field.="</p>";
        }

        return $field;
    }


    /**
     * Generate html Select tag
     *
     * @param array $options
     * @return string html
     */   
    public function createSelectTag($options) {
        $default = array('label' => '', 'attributes' => array(), 'values' => array(), 'p' => true, 'p_class' => false, 'selectedindex' => 0, 'disabled' => array());
        $options = array_merge($default,$options);

        $select_field = '';

        if($p_class != false) {
            $pclass = ' class="'.$p_class.'"';
        } else {
            $pclass = '';
        }

        if ($p == true) {
            $select_field .= '<p'.$pclass.'>';
        }

        if ($options['label'] != '') {
            $select_field .= '<label for="'.$options['attributes']['name'].'">'.$options['label'].'</label>';
        }

        $select_field .= '<select'.Html::tagOptions($options['attributes']).'>';

        $tag_options = array();
        foreach($values as $value => $text) {
            $tag_options['value'] = $value;
            if ($val == $selectedindex) {
                $tag_options['selected'] = 'selected';
            }

            if (is_array($disabled) && in_array($val, $disabled)) {
                $tag_options['disabled'] = 'disabled';
            }

            $select_field .= '<option'.Html::tagOptions($tag_options).'>'.$text.'</option>';
        }

        $select_field .= '</select>';

        if ($p == true) {
            $select_field .= '</p>';
        }

        return $select_field;
    }
    

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
