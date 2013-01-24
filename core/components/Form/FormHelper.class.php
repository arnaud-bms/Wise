<?php
namespace Telelab\Form;

use Telelab\Component\Component;
use Telelab\Globals\Globals;
use Telelab\View\ViewHelper;
use Telelab\Html\Html;
use Telelab\Type\ArrayType;

/**
 * FormHelper: Helper that generate form components (html) and handle it
 *
 * @author fmanas <f.manas@telemaque.fr>
 */
class FormHelper extends Component
{
    /**
     * Generate html tag
     *
     * @param array $options
     * @return string html
     */   
    public static function createTag($options = array())
    {
        $default = array(
            'type' => 'input',
            'label' => null,
            'value' => '', 
            'parent' => array('input' => array('active' => false, 'tag' => 'div', 'attributes' => array('class' => 'inputs')), 'group' => array('active' => false, 'tag' => 'div', 'attributes' => array('class' => 'control-group'))),
            'attributes' => array('name' => 'ipt')
        );

        $options = ArrayType::mergeRecursive($default, $options);

        $tag = '';

        // Parent group tag
        if ($options['parent']['group']['active'] == true) {
            $tag .= '<'.$options['parent']['group']['tag'].Html::tagOptions($options['parent']['group']['attributes']).'>';
        }

        $for = isset($options['attributes']['id']) ? $options['attributes']['id'] : $options['attributes']['name'];

        if ($options['label'])  {
            $tag .= '<label id="label_'.$for.'" for="'.$for.'">'.$options['label'].'</label>';
        }

        // Parent input tag
        if ($options['parent']['input']['active'] == true) {
            $tag .= '<'.$options['parent']['input']['tag'].Html::tagOptions($options['parent']['input']['attributes']).'>';
        }

        switch ($options['type']) {
            case 'input':
                $tag .= '<input'.Html::tagOptions($options['attributes']).' value="'.$options['value'].'" />';
            break;
            case 'textarea':
                $tag .= '<textarea '.Html::tagOptions($options['attributes']).'>'.$options['value'].'</textarea>';
            break;
        }

        if ($options['parent']['input']['active'] == true) {
            $tag .= '</'.$options['parent']['input']['tag'].'>';
        }

        if ($options['parent']['group']['active'] == true) {
            $tag .= '</'.$options['parent']['group']['tag'].'>';
        }
 
        return $tag;
    }


    /**
     * Generate html Select tag
     *
     * @param array $options
     * @return string html
     */   
    public static function createSelectTag($options)
    {
        $default = array(
            'label' => null,
            'attributes' => array(),
            'values' => array(),
            'selectedindex' => 0,
            'disabled' => array(),
            'parent' => array('input' => array('active' => false, 'tag' => 'div', 'attributes' => array('class' => 'inputs')), 'group' => array('active' => false, 'tag' => 'div', 'attributes' => array('class' => 'control-group')))
        );

        $options = ArrayType::mergeRecursive($default, $options);

        $select_tag = '';

        // Parent group tag
        if ($options['parent']['group']['active'] == true) {
            $select_tag .= '<'.$options['parent']['group']['tag'].Html::tagOptions($options['parent']['group']['attributes']).'>';
        }

        $for = isset($options['attributes']["id"]) ? $options['attributes']['id'] : $options['attributes']['name'];

        if ($options['label'] != '')  {
            $select_tag .= '<label id="label_'.$for.'" for="'.$for.'">'.$options['label'].'</label>';
        }

        // Parent input tag
        if ($options['parent']['input']['active'] == true) {
            $tag .= '<'.$options['parent']['input']['tag'].Html::tagOptions($options['parent']['input']['attributes']).'>';
        }

        $select_tag .= '<select'.Html::tagOptions($options['attributes']).'>';

        $tag_options = array();
        foreach($options['values'] as $value => $text) {
            $tag_options['value'] = $value;
            if ($value == $options['selectedindex']) {
                $tag_options['selected'] = 'selected';
            }

            $disabled = (array)$options['disabled'];
            if (in_array($value, $disabled)) {
                $tag_options['disabled'] = 'disabled';
            }

            $select_tag .= '<option'.Html::tagOptions($tag_options).'>'.$text.'</option>';
        }

        $select_tag .= '</select>';

        if ($options['parent']['input']['active'] == true) {
            $select_tag .= '</'.$options['parent']['input']['tag'].'>';
        }

        if ($options['parent']['group']['active'] == true) {
            $select_tag .= '</'.$options['parent']['group']['tag'].'>';
        }

        return $select_tag;
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