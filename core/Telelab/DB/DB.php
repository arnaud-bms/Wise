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
    private static $_instance = null;

    /**
     * @var Connection to DB
     */
    private static $_driver = null;
    
    /**
     * @var String Charset to use
     */
    private static $_charset = null;

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
    protected function _init($config)
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

        self::$_driver = new $driver(
            $config['host'],
            $config['dbname'],
            $config['user'],
            $config['password']
        );

        if (isset($config['charset']) && $config['charset'] !== null) {
            self::$_charset = $config['charset'];
            self::$_driver->setCharset($config['charset']);
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
        if (!self::$_instance instanceOf DB) {
            Logger::log('['.__CLASS__.'] new instance', Logger::LOG_DEBUG);
            self::$_instance = new DB($config);
        }

        return self::$_instance;
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
        return call_user_func_array(array(self::$_driver, $method), $argv);
    }


    /**
     * Reset connection with database
     */
    public static function reset()
    {
       self::$_driver->reset();
       
       if (self::$_charset !== null) {
            self::$_driver->setCharset(self::$_charset);
        }
    }


    /**
     * Close connection on driver and remove ref to driver
     *
     * @return Driver
     */
    public function close()
    {
        self::$_instance = null;
        self::$_driver->close();
    }
}