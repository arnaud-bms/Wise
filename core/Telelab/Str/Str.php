<?php
namespace Telelab\Str;

use \Telelab\Component\ComponentStatic;

/**
 * String
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Str extends ComponentStatic
{

    /**
     * Lower
     *
     * @param type $string
     * @return string
     */
    public static function lower($string)
    {
        return strtolower($string);
    }


    /**
     * Upper
     *
     * @param type $string
     * @return string
     */
    public static function upper($string)
    {
        return strtoupper($string);
    }


    /**
     * UcFirst
     *
     * @param type $string
     * @return string
     */
    public static function ucfirst($string)
    {
        return ucfirst($string);
    }


    /**
     * Url
     *
     * @param type $string
     * @return string
     */
    public static function url($string, $separator = '-')
    {
        $string = self::removeAccent($string);
        $string = preg_replace('#([^a-zA-Z0-9])#', $separator, $string);
        $string = preg_replace('#\\'.preg_quote($separator).'{2,}#', $separator, $string);
        $string = preg_replace('#(^'.preg_quote($separator).')|('.preg_quote($separator).'$)#', '', $string);

        return strtolower($string);
    }


    /**
     * Check if the string is utf8
     *
     * @see http://fr2.php.net/manual/fr/function.mb-detect-encoding.php#68607
     * @param string $string
     * @return bool
     */
    public static function isUtf8($string)
    {
        return preg_match(
            '%(?:
            [\xC2-\xDF][\x80-\xBF]        # non-overlong 2-byte
            |\xE0[\xA0-\xBF][\x80-\xBF]               # excluding overlongs
            |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}      # straight 3-byte
            |\xED[\x80-\x9F][\x80-\xBF]               # excluding surrogates
            |\xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
            |[\xF1-\xF3][\x80-\xBF]{3}                  # planes 4-15
            |\xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
            )+%xs',
            $string
        ) === 1;
    }


    /**
     * Accent
     *
     * @param string $string
     * @return string
     */
    public static function removeAccent($string)
    {
        if (!self::isUtf8($string)) {
            $string = utf8_encode($string);
        }
        
        $string = htmlentities($string, ENT_NOQUOTES, 'UTF-8');
        return preg_replace('#&([a-zA-Z])[a-zA-Z]+;#', '$1', $string);
    }


    /**
     * Hash string
     *
     * @param string $string
     * @return string
     */
    public static function hash($string)
    {
        if (!empty($string)) {
            $nbHash = ceil(substr($string, 0, 1)/10)*2+2;
            for ($i = 0; $i < $nbHash; $i++) {
                $string = md5($string);
            }
        }
        return $string;
    }


    /**
     * Normalize phone number
     *
     * @param string $number
     * @return $number
     */
    public static function normalizePhoneNumber($number)
    {
        $number = preg_replace('/([^0-9]+)/', '', $number);
        if (substr($number, 0, 1) == '0' && substr($number, 0, 2) !== '00') {
            $number = '33'.substr($number, 1);
        }

        return (int)$number;
    }


    /**
     * Convert string to literalize string (on|off|yes|no|1|'')
     *
     * @param mixed $value
     */
    public static function literalize($value)
    {
        // lowercase our value for comparison
        $value  = trim($value);
        $lvalue = strtolower($value);

        if (in_array($lvalue, array('null', '~', ''))) {
            $value = null;
        } elseif (in_array($lvalue, array('true', 'on', '+', 'yes'))) {
            $value = true;
        } elseif (in_array($lvalue, array('false', 'off', '-', 'no'))) {
            $value = false;
        } elseif (ctype_digit($value)) {
            $value = (int) $value;
        } elseif (is_numeric($value)) {
            $value = (float) $value;
        }

        return $value;
    }


    /**
     * escape string with special chars
     *
     * @param string $string
     * @return string
     */
    public static function escapeOnce($string)
    {
        return self::fixDoubleEscape(htmlspecialchars($string, ENT_COMPAT, 'UTF-8'));
    }


    /**
     * fix string double escape
     *
     * @param string $string
     * @return string
     */
    public static function fixDoubleEscape($string)
    {
        return preg_replace('/&amp;([a-z]+|(#\d+)|(#x[\da-f]+));/i', '&$1;', $string);
    }


    /**
     * convert string to camelcase format (e.g. "this_method_name" -> "ThisMethodName")
     *
     * @param string $string
     * @return string
     */
    public static function camelcase($string)
    {
        return preg_replace('/(?:^|_)(.?)/e', "self::upper('$1')", self::lower($string));
    }


    /**
     * Convert camel case string to underscore format
     *
     * @param string $string
     * @return string
     */
    public static function camelcaseToUnderscores($string)
    {
        return self::lower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $string));
    }


    /**
     * Add slashes to string if doesn't exists
     *
     * @param string $string
     */
    public static function checkAddslashes($string)
    {
        if (strpos(str_replace("\'", "", " $string"), "'") != false) {
            $string = addslashes($string);
        }

        return $string;
    }
    
    
    /**
     * Unserialize for multibytes
     * 
     * @param string $string
     * @return array
     */
    public static function mbUnserialize($string)
    {
        $string = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $string);

        return unserialize($string);
    }
}
