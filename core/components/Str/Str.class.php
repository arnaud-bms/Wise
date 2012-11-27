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
        $string = preg_replace(
            '#\\'.preg_quote($separator).'{2,}#', $separator, $string
        );
        $string = preg_replace(
            '#(^'.preg_quote($separator).')|('.preg_quote($separator).'$)#',
            '',
            $string
        );

        return strtolower($string);
    }


    /**
     * Accent
     *
     * @param string $string
     * @return string
     */
    public static function removeAccent($string)
    {
        if (mb_detect_encoding($string) !== 'UTF-8') {
            $string = utf8_encode($string);
        }

        $string = htmlentities($string, ENT_NOQUOTES, 'UTF-8');
        return preg_replace('#&([a-zA-Z])[a-zA-Z]+;#', '$1', $string);
    }
}
