<?php
namespace Telco\DB\Driver;

use Telco\DB\DBException;

/**
 * Connector to database
 *
 * @author gdievart
 */
class PDO implements Driver
{
    /**
     * @var PDO Ref to PDO 
     */
    private $_PDO;
    
    /**
     * Init PDO Driver
     *  
     * @param type $host
     * @param type $dbname
     * @param type $user
     * @param type $password
     * @throws DBException 
     */
    public function __construct($host, $dbname, $user, $password)
    {
        $dsn      = sprintf('mysql:host=%s;dbname=%s;', $host, $dbname);
        try {
            $this->_PDO = new \PDO($dsn, $user, $password);
        } catch(\PDOException $e) {
            throw new DBException($e->getMessage(), $e->getCode());
        }
    }
    
    
    /**
     * Execute query and return result
     * 
     * @param type $query 
     * @return stmt
     */
    public function query($query)
    {
        return $this->_PDO->query($query);
    }
    
    
    /**
     * Execute query and return rows affected
     * 
     * @param type $query 
     * @return int
     */
    public function exec($query)
    {
        return $this->_PDO->exec($query);
    }
    
    
    /**
     * Execute query and return rows affected
     * 
     * @param string $query 
     * @return string
     */
    public function escape($string)
    {
        return $this->_PDO->quote($string);
    }
}