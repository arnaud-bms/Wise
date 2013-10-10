<?php
namespace Telelab\Conf;

use Telelab\Component\ComponentStatic;
use Telelab\Conf\ConfException;
use Telelab\Logger\Logger;

/**
 * Conf: Configuration Class from files
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class Conf extends ComponentStatic
{

    /**
     * @var array List config setted
     */
    protected static $_config = array();

    /**
     * @var Cache
     */
    protected static $_cache;

    /**
     * Set config
     *
     * @param string $fileConf
     */
    public static function loadConfig($fileConf)
    {
        self::_initCache();
        self::$_config = self::_getConfFromFile($fileConf);
    }


    /**
     * Overwrite main config
     *
     * @param string $fileConf
     */
    public static function mergeConfig($fileConf)
    {
        self::_initCache();
        self::$_config = array_merge(
            self::$_config,
            self::_getConfFromFile($fileConf)
        );
    }


    /**
     * Init cache system if the section conf_cache exist
     */
    private static function _initCache()
    {
        if (self::$_cache === null && $cacheConf = self::getConfig('conf_cache')) {
            self::$_cache = new \Telelab\Cache\Cache($cacheConf);
        }
    }


    /**
     * Retrieve conf from file
     *
     * @param string $fileConf
     * @throws ConfException If is invalid configuration file
     * @return array
     */
    private static function _getConfFromFile($fileConf)
    {
        $cacheId = 'telelab:conf:'.md5($fileConf);
        if (self::$_cache !== null && $config = self::$_cache->getCache($cacheId)) {
            Logger::log('['.__CLASS__.'] conf file from cache -> '.$fileConf, Logger::LOG_DEBUG);
            return $config;
        }

        $typeFile = substr($fileConf, strrpos($fileConf, '.')+1);
        switch($typeFile) {
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
            default:
                throw new ConfException("File '$fileConf' it's not valid", 400);
        }

        if (self::$_cache !== null) {
            self::$_cache->setCache($cacheId, $config);
        }

        return $config;
    }


    /**
     * Retrieve config
     *
     * @param string $section
     * @return mixed
     */
    public static function getConfig($section = null)
    {
        $config = self::$_config;
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
     * @param mixed $newConfig
     */
    public static function setConfig($section, $newConfig)
    {
        $config =& self::$_config;
        $section = explode('.', $section);
        foreach ($section as $field) {
            if (isset($config[$field])) {
                $config =& $config[$field];
            } else {
                $config[$field] = null;
            }
        }
        $config = $newConfig;
    }


    /**
     * Browse array to rewrite config into multi depth array (recursive method)
     *
     * @param array $config
     * @return array $newConfig
     */
    public static function rewriteConfig($config)
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