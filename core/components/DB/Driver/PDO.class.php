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
     * 
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
     */
    public function query($query)
    {
        
    }
}