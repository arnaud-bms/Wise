<?php
namespace Wise\Conf;

use Wise\Conf\ConfException;

/**
 * Class \Wise\Conf\Conf
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Conf
{

    /**
     * @var array List config setted
     */
    protected static $config = array();

    /**
     * Set config
     *
     * @param string $fileConf
     */
    public static function load($fileConf)
    {
        self::$config = self::getConfFromFile($fileConf);
    }

    /**
     * Overwrite main config
     *
     * @param string $fileConf
     */
    public static function merge($fileConf)
    {
        self::$config = array_merge(
            self::$config,
            self::getConfFromFile($fileConf)
        );
    }

    /**
     * Retrieve conf from file
     *
     * @param  string        $fileConf
     * @throws ConfException If is invalid configuration file
     * @return array
     */
    private static function getConfFromFile($fileConf)
    {
        $typeFile = substr($fileConf, strrpos($fileConf, '.')+1);
        switch ($typeFile) {
            case 'json':
                if (!$config = @json_decode(file_get_contents($fileConf), true)) {
                    throw new ConfException("Json file '$fileConf' is not valid", 401);
                }
                break;
            case 'ini':
                if (!$config = @parse_ini_file($fileConf, true)) {
                    throw new ConfException("Ini file '$fileConf' is not valid", 402);
                }
                break;
            case 'php':
                $config = @include $fileConf;
                break;
            default:
                throw new ConfException("File '$fileConf' it's not valid", 400);
        }

        return $config;
    }

    /**
     * Retrieve config
     *
     * @param  string $section
     * @return mixed
     */
    public static function get($section = null)
    {
        $config = self::$config;
        if ($section !== null) {
            $section = explode('.', $section);
            foreach ($section as $field) {
                $config = isset($config[$field]) ? $config[$field] : false;
            }
        }
        
        return $config;
    }

    /**
     * Retrieve config
     *
     * @param string $section
     * @param mixed  $newConfig
     */
    public static function set($section, $newConfig)
    {
        $config =& self::$config;
        $section = explode('.', $section);
        foreach ($section as $field) {
            if (!array_key_exists($field, $config)) {
                $config[$field] = null;
            }
            $config =& $config[$field];
        }
        $config = $newConfig;
    }

    /**
     * Browse array to rewrite config into multi depth array (recursive method)
     *
     * @param  array $config
     * @return array $newConfig
     */
    public static function rewrite($config)
    {
        foreach ($config as $options => $value) {
            $optionsDepth = explode('.', $options);
            if (count($optionsDepth) === 1) {
                if (is_array($value)) {
                    $configToMerge[$options] = self::rewriteConfig($value);
                } else {
                    $configToMerge[$options] = $value;
                }
            } else {
                $firstDepth = array_shift($optionsDepth);
                $configToMerge[$firstDepth] = self::rewriteConfig(array(implode('.', $optionsDepth) => $value));
            }
        }

        return $configToMerge;
    }
}
