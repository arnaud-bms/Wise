<?php
namespace Telelab\Html;

use Telelab\Component\Component;
use Telelab\Str\Str;

/**
 * Html: basics methods and helpers for HTML
 *
 * @author fmanas <f.manas@telemaque.fr>
 */
class Html extends Component
{
    /**
     * Convert array to string attributes
     *
     * @param array $options
     */
    public static function tagOptions($options = array())
    {
        $options = self::_parseAttributes($options);

        $html = '';
        foreach ($options as $key => $value) {
          $html .= ' '.$key.'="'.Str::escapeOnce($value).'"';
        }
        return $html;
    }


    /**
     * Convert attributes to array attributes
     *
     * @param string $options
     * @return mixed
     */
    protected static function _parseAttributes($string)
    {
        return is_array($string) ? $string : self::stringToArray($string);
    }


    /**
     * Convert string tag with attributes to an array
     *
     * @param string $string
     * @return array
     */
    public static function stringToArray($string = '')
    {
        preg_match_all('/
            \s*(\w+)              # key                               \\1
            \s*=\s*               # =
            (\'|")?               # values may be included in \' or " \\2
            (.*?)                 # value                             \\3
            (?(2) \\2)            # matching \' or " if needed        \\4
            \s*(?:
                (?=\w+\s*=) | \s*$  # followed by another key= or the end of the string
            )
            /x', $string, $matches, PREG_SET_ORDER
        );

        $attributes = array();
        foreach ($matches as $val) {
            $attributes[$val[1]] = literalize($val[3]);
        }

        return $attributes;
    }
}