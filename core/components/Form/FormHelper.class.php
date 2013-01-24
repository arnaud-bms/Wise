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

        if ($options['label']) {
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

        $selectTag = '';

        // Parent group tag
        if ($options['parent']['group']['active'] == true) {
            $selectTag .= '<'.$options['parent']['group']['tag'].Html::tagOptions($options['parent']['group']['attributes']).'>';
        }

        $for = isset($options['attributes']["id"]) ? $options['attributes']['id'] : $options['attributes']['name'];

        if ($options['label'] != '') {
            $selectTag .= '<label id="label_'.$for.'" for="'.$for.'">'.$options['label'].'</label>';
        }

        // Parent input tag
        if ($options['parent']['input']['active'] == true) {
            $tag .= '<'.$options['parent']['input']['tag'].Html::tagOptions($options['parent']['input']['attributes']).'>';
        }

        $selectTag .= '<select'.Html::tagOptions($options['attributes']).'>';

        $tagOptions = array();
        foreach ($options['values'] as $value => $text) {
            $tagOptions['value'] = $value;
            if ($value == $options['selectedindex']) {
                $tagOptions['selected'] = 'selected';
            }

            $disabled = (array)$options['disabled'];
            if (in_array($value, $disabled)) {
                $tagOptions['disabled'] = 'disabled';
            }

            $selectTag .= '<option'.Html::tagOptions($tagOptions).'>'.$text.'</option>';
        }

        $selectTag .= '</select>';

        if ($options['parent']['input']['active'] == true) {
            $selectTag .= '</'.$options['parent']['input']['tag'].'>';
        }

        if ($options['parent']['group']['active'] == true) {
            $selectTag .= '</'.$options['parent']['group']['tag'].'>';
        }

        return $selectTag;
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

        $elementsPicture = empty($options['picture']) ? '/img/icons/captcha/fruits.jpg' : $options['picture'];

        $elements         = empty($options['items']) ? array('cerise' => 'la', 'poire' => 'la', 'fraises' => 'les', 'pomme' => 'la', 'prunes' => 'les') : $options['items'];
        $elementsValues  = array_keys($elements);
        $elementsShuffle = $elementsValues;
        shuffle($elementsShuffle);

        $size = empty($options['size']) ? 57 : $options['size'];

        $rand = mt_rand(0, (sizeof($elements) - 1));

        $element = array($elements[$elementsShuffle[$rand]].($elements[$elementsShuffle[$rand]] == "l'" ? '' : ' '), $elementsShuffle[$rand]);

        $captcha .= '<label for="captcha">'.str_replace(array('#DET#', '#OBJ#'), $element, $options['message']).'</label>';

        $captcha .= '<input type="hidden" id="captcha" name="captcha" data-type="captcha" data-required="true" />';


        $elementsCodes = array();
        for ($i = 0 ; $i < sizeof($elementsShuffle); $i++) {
            $elementsCodes[$i] = mt_rand();

            $keyShuffle = $elementsShuffle[$i];
            $key = array_search($keyShuffle, $elementsValues);

            $captcha .= '<div class="captcha_item" style="background: url('.$elementsPicture.') -'.($key * $size).'px top no-repeat; width: '.$size.'px; height: '.$size.'px; cursor: pointer;" data-value="'.$elementsCodes[$i].'"></div>';
        }

        Globals::get('session')->captcha = $elementsCodes[$rand];

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
     * @return boolean
     */
    public static function isValidCaptcha($code = null)
    {
        if (Globals::get('session')->captcha) {
            if ($code == Globals::get('session')->captcha && $code != '') {
                return true;
            }
        }

        return false;
    }
}