<?php
namespace Telco\DB\Driver;

use Telco\DB\DBException;
use Telco\DB\Driver\MySQLiStatement;

/**
 * Connector to database
 *
 * @author gdievart <dievartg@gmail.com>
 */
class MySQLi implements Driver 
{
    /**
     * @var handle Ref to MySQLi
     */
    private $_mysqli;
    
    /**
     * Init MySQLi Driver
     *  
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     */
    public function __construct($host, $dbname, $user, $password)
    {
        $this->_mysqli = new mysqli($host, $user, $password, $dbname);   
    }
    
    
    /**
     * Execute query and return result
     * 
     * @param type $query 
     * @return stmt
     */
    public function query($query)
    {
        return new MySQLiStatement($this->_mysqli->query($query));
    }
    
    
    /**
     * Execute query and return rows affected
     * 
     * @param type $query 
     * @return int Rows affected
     */
    public function exec($query)
    {
        if($this->_mysqli->query($query)) {
            return $this->_mysqli->affected_rows;
        }
        
        return 0;
    }
    
    
    /**
     * Execute query and return rows affected
     * 
     * @param string $query 
     * @return string
     */
    public function escape($string)
    {
        return $this->_mysqli->real_escape_string($string);
    }
    
    
    /**
     * Close connection with database
     */
    public function close()
    {
        $this->_mysqli->close();
    }
}