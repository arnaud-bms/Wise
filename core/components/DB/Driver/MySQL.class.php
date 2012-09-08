<?php
namespace Telco\DB\Driver;

use Telco\DB\DBException;
use Telco\DB\Driver\MySQLStatement;

/**
 * Connector to database
 *
 * @author gdievart <dievartg@gmail.com>
 */
class MySQL implements Driver 
{
    /**
     * @var handle Ref to link
     */
    private $_link;
    
    /**
     * Init PDO Driver
     *  
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     */
    public function __construct($host, $dbname, $user, $password)
    {
        $this->_link = mysql_connect($host, $user, $password, true);
        mysql_select_db($dbname);
    }
    
    
    /**
     * Execute query and return result
     * 
     * @param type $query 
     * @return stmt
     */
    public function query($query)
    {
        if($resource = mysql_query($query, $this->_link)) {
            return new MySQLStatement($resource);
        }
        
        return false;
    }
    
    
    /**
     * Execute query and return rows affected
     * 
     * @param type $query 
     * @return int Rows affected
     */
    public function exec($query)
    {
        return mysql_query($query) ? mysql_affected_rows() : 0;
    }
    
    
    /**
     * Execute query and return rows affected
     * 
     * @param string $query 
     * @return string
     */
    public function escape($string)
    {
        return mysql_real_escape_string($string);
    }
    
    
    /**
     * Close connection with database
     */
    public function close()
    {
        mysql_close($this->_link);
    }
}