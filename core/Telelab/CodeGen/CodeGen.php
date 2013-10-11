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

    /**
     * @var array list chars used for generate code
     */
    private static $chars = array();

    /**
     * @var array Words used for generate simple code
     */
    private static $_words = array(
        "bleu","blanc","rouge","jaune","vert","violet","affichera",
        "chaine","genre","retourne","fonction","commentaire","lapin","renard","image",
        "mathematique","aleatoire","hasard","source","chat","souris","chapeau","langue",
        "arbre","generer","livre","supposon","tout","vecteur","construction","violon",
        "flute","fuite","zebre","zoro","xylophone","deux","trois","quatre","cinq","sept",
        "huit","neuf","douze","treize"
    );

    /**
     * @var int  pronounceability
     */
    private static $_pronounceability = 1;

    /**
     * Init CodeGen
     */
    protected static function _init($config)
    {
        self::$chars['0-9'] = array_map('chr', range(48, 57));
        self::$chars['A-Z'] = array_map('chr', range(65, 90));
        self::$chars['a-z'] = array_map('chr', range(97, 122));
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
        foreach (self::$chars as $key => $listChars) {
            if (strpos($chars, $key) !== false) {
                $charsUsedToGenerate = array_merge($charsUsedToGenerate, self::$chars[$key]);
            }
        }

        return $charsUsedToGenerate;
    }


    /**
     * Generate simple word
     *
     * @author mercier133 http://www.servicesgratis.net
     * @return string
     */
    public static function generateWord()
    {
        $m1 = self::$_words[rand(0, count(self::$_words) - 1)];
        $result = substr($m1, 0, rand(2, strlen($m1) - 1));

        $countWords = count(self::$_words);
        for ($i = 0; $i < rand(3, 4); $i++) {

            $pasOk=true;
            $x =0;
            while ($pasOk && $x<100) {

                $m = self::$_words[rand(0, $countWords - 1)];
                while ($m == $m1) {
                    $m = self::$_words[rand(0, $countWords - 1)];
                }

                if (preg_match('#'.substr($result, -self::$_pronounceability).'#', $m)) {
                    $pasOk = false;
                    $m2 = explode(substr($result, -1), $m);
                    $result .= substr($m2[1], 0, rand(2, strlen($m2[1]) - 1));
                }
                $x++;
            }

            if ($x==100) {
                return self::generateWord();
            }
        }

        if (strlen($result) < 4) {
            return self::generateWord();
        }

        return $result;
    }
}