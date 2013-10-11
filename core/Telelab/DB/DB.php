<?php
namespace Telelab\DB;

use Telelab\Component\Component;
use Telelab\Logger\Logger;

/**
 * DB: Connector to database
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class DB extends Component
{
    /**
     * @var DB
     */
    private static $instance = null;

    /**
     * @var Connection to DB
     */
    private static $driver = null;
    
    /**
     * @var String Charset to use
     */
    private static $charset = null;

    /**
     * @var array Required fields
     */
    protected $_requiredFields = array(
        'driver',
        'host',
        'dbname',
        'user',
        'password'
    );


    /**
     * Init DB
     *
     * @param array $config
     * @throws DBException
     */
    protected function init($config)
    {
        switch($config['driver']) {
            case 'pdo':
                $driver = 'Telelab\DB\Driver\PDO';
                break;
            case 'mysql':
                $driver = 'Telelab\DB\Driver\MySQL';
                break;
            case 'mysqli':
                $driver = 'Telelab\DB\Driver\MySQLi';
                break;
            default:
                throw new DBException(
                    "Driver '{$config['driver']}' does'nt exists", 400
                );
        }

        self::$driver = new $driver(
            $config['host'],
            $config['dbname'],
            $config['user'],
            $config['password']
        );

        if (isset($config['charset']) && $config['charset'] !== null) {
            self::$charset = $config['charset'];
            self::$driver->setCharset($config['charset']);
        }
    }


    /**
     * Get instance DB
     *
     * @param array $config
     * @return DB
     */
    public static function getInstance($config = null)
    {
        if (!self::$instance instanceOf DB) {
            Logger::log('['.__CLASS__.'] new instance', Logger::LOG_DEBUG);
            self::$instance = new DB($config);
        }

        return self::$instance;
    }


    /**
     * Call method on driver
     *
     * @param string $method
     * @param array $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        return call_user_func_array(array(self::$driver, $method), $argv);
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
     * Close connection on driver and remove ref to driver
     *
     * @return Driver
     */
    public function close()
    {
        self::$instance = null;
        self::$driver->close();
    }
}
