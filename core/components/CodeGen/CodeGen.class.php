<?php
namespace Telelab\CodeGen;

use Telelab\Component\ComponentStatic;

/**
 * CodeGen: Generate code, password, token ...
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class CodeGen extends ComponentStatic
{

    private static $_chars = array();


    /**
     * Init CodeGen
     */
    protected static function _init($config)
    {
        self::$_chars['0-9'] = array_map('chr', range(48, 57));
        self::$_chars['A-Z'] = array_map('chr', range(65, 90));
        self::$_chars['a-z'] = array_map('chr', range(97, 122));
    }


    /**
     * Generate random code
     *
     * @param int $length
     * @param string $chars
     * @return string Code generated
     */
    public static function generate($length, $chars = 'a-zA-Z0-9')
    {
        $codeGenerated = '';
        $charsToUsed = self::_getCharsToUsed($chars);
        for ($i = 0; $i < $length; $i++) {
            $codeGenerated.= $charsToUsed[mt_rand(0, (count($charsToUsed)-1))];
        }

        return $codeGenerated;
    }


    /**
     * Extract list chars used for generated code
     *
     * @param string $chars
     * @return array List chars used
     */
    private static function _getCharsToUsed($chars)
    {
        $charsUsedToGenerate = array();
        foreach (self::$_chars as $key => $listChars) {
            if (strpos($chars, $key) !== false) {
                $charsUsedToGenerate = array_merge($charsUsedToGenerate, self::$_chars[$key]);
            }
        }

        return $charsUsedToGenerate;
    }
}