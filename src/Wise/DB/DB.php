<?php
namespace Wise\DB;

use Wise\Component\Component;

/**
 * Class \Wise\DB\DB
 *
 * This class is used to communicate with a database
 *
 * @author gdievart <dievartg@gmail.com>
 */
class DB extends Component
{
    /**
     * Reference on the singleton
     *
     * @var \Wise\DB\DB
     */
    private static $instance = null;

    /**
     * The driver used to connect the database
     *
     * @var \Wise\DB\Driver
     */
    private static $driver = null;

    /**
     * Charset to use
     *
     * @var String
     */
    private static $charset = null;

    /**
     * {@inherit}
     */
    protected $requiredFields = array(
        'driver',
        'host',
        'dbname',
        'user',
        'password'
    );

    /**
     * {@inherit}
     */
    protected function init($config)
    {
        $classname = 'Wise\DB\Driver\\'.ucfirst((string) $config['driver']);
        if (!class_exists($classname, true) || !in_array('Wise\DB\Driver\DB', class_implements($classname, true))) {
            throw new Exception('The driver "'.$classname.'" is not valid', 0);
        }

        self::$driver = new $classname($config['host'], $config['dbname'], $config['user'], $config['password']);
        if (isset($config['charset']) && $config['charset'] !== null) {
            self::$charset = $config['charset'];
            self::$driver->setCharset($config['charset']);
        }
    }

    /**
     * Get instance to DB
     *
     * @param  array       $config
     * @return \Wise\DB\DB
     */
    public static function getInstance($config = null)
    {
        if (!self::$instance instanceof DB) {
            self::$instance = new DB($config);
        }

        return self::$instance;
    }

    /**
     * Call method on driver
     *
     * @param  string $method
     * @param  array  $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        return call_user_func_array(array(self::$driver, $method), $argv);
    }

    /**
     * @see \Wise\DB\Driver\DB
     */
    public function query($query)
    {
        return self::$driver->query($query);
    }

    /**
     * @see \Wise\DB\Driver\DB
     */
    public function exec($query)
    {
        return self::$driver->exec($query);
    }

    /**
     * @see \Wise\DB\Driver\DB
     */
    public function setCharset($charset)
    {
        return self::$driver->setCharset($charset);
    }

    /**
     * @see \Wise\DB\Driver\DB
     */
    public function escape($query)
    {
        return self::$driver->escape($query);
    }

    /**
     * @see \Wise\DB\Driver\DB
     */
    public function getLastIdInsert()
    {
        return self::$driver->getLastIdInsert();
    }

    /**
     * Reset connection with database
     */
    public static function reset()
    {
        self::$driver->reset();

        if (self::$charset !== null) {
            self::$driver->setCharset(self::$charset);
        }
    }

    /**
     * Close connection on the driver and remove the reference to singleton
     */
    public function close()
    {
        self::$instance = null;
        self::$driver->close();
    }
}
