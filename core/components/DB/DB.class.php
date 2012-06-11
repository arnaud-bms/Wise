<?php
namespace Telco\DB;

use Telco\Component\Component;

/**
 * Connector to database
 *
 * @author gdievart
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
     * @var array Drivers available 
     */
    private $_driverAvailable = array(
        'pdo'    => 'PDO',
        'mysql'  => 'MySQL',
        'mysqli' => 'MySQLI'
    );
    
    
    /**
     * Init DB
     * 
     * @param array $config
     */
    protected function _init($config)
    {
        if(!array_key_exists($config['driver'], $this->_driverAvailable)) {
            throw new DBException("Driver '{$config['driver']}' does'nt exists", 400);
        }
        
        $host      = $config['host'];
        $dbname    = $config['dbname'];
        $user      = $config['user'];
        $password  = $config['password'];
        $driver    = 'Telco\DB\Driver\\'.$this->_driverAvailable[$config['driver']];
        
        $this->_driver = new $driver($host, $dbname, $user, $password);
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
        
        return self::$_instance;
    }
    
    
    /**
     * Execute query read
     * 
     * @param string $query
     * @return PDOStatement
     */
    public function query($query) {
        return $this->_driver->query($query);
    }
    
    
    /**
     * Execute query write
     * 
     * @param string $query
     * @return PDOStatement
     */
    public function exec($query) {
        return $this->_driver->exec($query);
    }
    
    
    /**
     * Prepare query
     * 
     * @param string $sQuery
     * @return PDOStatement
     */
    public function prepare($sQuery) {
        return $this->_driver->prepare($sQuery);
    }
    
    
    /**
     * Get last id insert
     * 
     * @return int
     */
    public function lastInsertId() {
        return $this->_driver->lastInsertId();
    }
    
    
    /**
     * Get errorInfo
     * 
     * @return array 
     */
    public function errorInfo() {
        return $this->_driver->errorInfo();
    }
    
    
    /**
     * Protect string to inject
     * 
     * @param string $sString
     * @return string
     */
    public function quote($sString) {
        return $this->_driver->quote($sString);
    }
    
    
    /**
     * close connection to DB
     */
    public static function close() {
        self::$_instance = null;
        $this->_driver = null;
    }
}
