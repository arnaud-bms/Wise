<?php
namespace Wise\Db;

use Wise\Component\Component;

/**
 * Class \Wise\Db\Db
 *
 * This class is used to communicate with a database
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Db extends Component
{
    /**
     * Reference on the singleton
     *
     * @var \Wise\Db\Db
     */
    private static $instance = null;

    /**
     * The driver used to connect the database
     *
     * @var \Wise\Db\Driver
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
        $classname = 'Wise\Db\Driver\\'.ucfirst((string) $config['driver']);
        if (!class_exists($classname, true) || !in_array('Wise\Db\Driver\Db', class_implements($classname, true))) {
            throw new Exception('The driver "'.$classname.'" is not valid', 0);
        }

        $class = new \ReflectionClass($classname);
        self::$driver = $class->newInstance($config['host'], $config['dbname'], $config['user'], $config['password']);
        if (isset($config['charset']) && $config['charset'] !== null) {
            self::$charset = $config['charset'];
            self::$driver->setCharset($config['charset']);
        }
    }

    /**
     * Get instance to Db
     *
     * @param  array       $config
     * @return \Wise\Db\Db
     */
    public static function getInstance($config = null)
    {
        if (!self::$instance instanceof Db) {
            self::$instance = new Db($config);
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
     * @see \Wise\Db\Driver\Db
     */
    public function query($query)
    {
        if (false === $result = self::$driver->query($query)) {
            throw new Exception(self::$driver->error());
        }

        return $result;
    }

    /**
     * @see \Wise\Db\Driver\Db
     */
    public function exec($query)
    {
        if (false === $result = self::$driver->exec($query)) {
            throw new Exception(self::$driver->error());
        }

        return $result;
    }

    /**
     * @see \Wise\Db\Driver\Db
     */
    public function setCharset($charset)
    {
        return self::$driver->setCharset($charset);
    }

    /**
     * @see \Wise\Db\Driver\Db
     */
    public function escape($query)
    {
        return self::$driver->escape($query);
    }

    /**
     * @see \Wise\Db\Driver\Db
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
     * Ping the database and reopen it if the connection is closed
     */
    public function ping()
    {
        self::$driver->ping();
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
