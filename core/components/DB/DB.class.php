<?php
namespace Telelab\DB;

use Telelab\Component\Component;

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
    private $_driver = null;

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

        $this->_driver = new $driver(
            $config['host'],
            $config['dbname'],
            $config['user'],
            $config['password']
        );
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
        return call_user_func_array(array($this->_driver, $method), $argv);
    }


    /**
     * Close connection on driver and remove ref to driver
     *
     * @return Driver
     */
    public function close()
    {
        self::$_instance = null;
        $this->_driver->close();
    }
}
