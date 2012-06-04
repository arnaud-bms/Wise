<?php
namespace Tlc\DB;

use Tlc\Component\Component;
use PDO, PDOException;

/**
 * Description of DB
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
	 * @var PDO Connection to DB
	 */
	private $_PDO = null;
    
    /**
     * @var array Required fields 
     */
    protected $_requiredFields = array(
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
        $dsn      = sprintf('mysql:host=%s;dbname=%s;', $config['host'], $config['dbname']);
		$user     = $config['user'];
		$password = $config['password'];
		
		$this->_PDO = new PDO($dsn, $user, $password);
    }
    
    
    /**
	 * Get instance DB
	 * 
	 * @param array $config
	 * @return DB
	 */
	public static function getInstance($config) {
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
		return $this->_PDO->query($query);
	}
	
	
	/**
	 * Execute query write
	 * 
	 * @param string $query
	 * @return PDOStatement
	 */
	public function exec($query) {
		return $this->_PDO->exec($query);
	}
	
	
	/**
	 * Prepare query
	 * 
	 * @param string $sQuery
	 * @return PDOStatement
	 */
	public function prepare($sQuery) {
		return $this->_PDO->prepare($sQuery);
	}
	
	
	/**
	 * Get last id insert
	 * 
	 * @return int
	 */
	public function lastInsertId() {
		return $this->_PDO->lastInsertId();
	}
	
	
	/**
	 * Get errorInfo
	 * 
	 * @return array 
	 */
	public function errorInfo() {
		return $this->_PDO->errorInfo();
	}
	
	
	/**
	 * Protect string to inject
	 * 
	 * @param string $sString
	 * @return string
	 */
	public function quote($sString) {
		return $this->_PDO->quote($sString);
	}
	
	
	/**
	 * close connection to DB
	 */
	public static function close() {
		self::$_instance = null;
        $this->_PDO = null;
	}
}
