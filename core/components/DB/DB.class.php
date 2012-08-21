<?php
namespace Telco\DB;

use Telco\Component\Component;

/**
 * Connector to database
 *
 * @author gdievart <dievartg@gmail.com>
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
     */
    protected function _init($config)
    {
        switch($config['driver']) {
            case 'pdo':
                $driver = 'Telco\DB\Driver\PDO';
                break;
            case 'mysql':
                $driver = 'Telco\DB\Driver\MySQL';
                break;
            case 'mysqli':
                $driver = 'Telco\DB\Driver\MySQLi';
                break;
            default:
                throw new DBException("Driver '{$config['driver']}' does'nt exists", 400);
        }
        
        $this->_driver = new $driver(
                $config['host'], $config['dbname'], $config['user'], $config['password']);
    }
    
    
    /**
     * Get instance DB
     * 
     * @param array $config
     * @return DB
     */
    public static function getInstance($config = null) {
        if(!self::$_instance instanceOf DB) {
            self::$_instance = new DB($config);
        }
        
        return self::$_instance->getDriver();
    }
    
    
    /**
     * Return driver loaded
     * 
     * @return Driver 
     */
    public function getDriver()
    {
        return $this->_driver;
    }
}
