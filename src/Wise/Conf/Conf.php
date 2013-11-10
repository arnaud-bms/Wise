<?php
namespace Wise\Conf;

use Wise\Component\ComponentStatic;
use Wise\Conf\Exception;

/**
 * Class \Wise\Conf\Conf
 *
 * This class loads and manages the configuration
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Conf extends ComponentStatic
{
    /**
     * Configuration loaded
     *
     * @var array
     */
    protected static $config = array();

    /**
     * Load a file configuration
     *
     * @param mixed $conf
     */
    public static function load($conf)
    {
        if (is_string($conf)) {
            $conf = self::getConfFromFile((string) $conf);
        }
        self::getConfFromArray($conf);

        return self::$config;
    }

    /**
     * Load configuration from array
     *
     * @param  array $config
     * @return array $newConfig
     */
    private static function getConfFromArray($config)
    {
        foreach ($config as $key => $value) {
            self::set($key, $value);
        }
    }

    /**
     * Extract the configuration from a file
     *
     * @param  string    $file
     * @throws Exception If the file is invalid
     * @return array
     */
    private static function getConfFromFile($file)
    {
        if (!file_exists($file) || !is_readable($file)) {
            throw new Exception('The file "'.$file.'" is not readable', 0);
        }
        $typeFile = substr($file, strrpos($file, '.')+1);

        $classname = '\Wise\Conf\File\\'.ucfirst((string) $typeFile);
        if (!class_exists($classname, true) || !in_array('Wise\Conf\File\File', class_implements($classname, true))) {
            throw new Exception('The type file "'.$typeFile.'" is not valid', 0);
        }

        $class = new \ReflectionClass($classname);
        $class = $class->newInstance();

        return $class->extract($file);
    }

    /**
     * Merge the configuration with a new file
     *
     * @param mixed $conf
     */
    public static function merge($conf)
    {
        self::$config = array_merge(
            self::$config,
            self::load($conf)
        );
    }

    /**
     * Get configuration
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
     * Set configuration
     *
     * @param string $section
     * @param mixed  $newConfig
     */
    public static function set($section, $newConfig)
    {
        $config =& self::$config;
        $section = explode('.', $section);
        foreach ($section as $field) {
            if ($config === null || !array_key_exists($field, $config)) {
                $config[$field] = null;
            }
            $config =& $config[$field];
        }
        $config = $newConfig;
    }
}
