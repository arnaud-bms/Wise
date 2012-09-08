<?php
namespace Telco\DB\Driver;

use Telco\DB\Driver\Statement;

/**
 * MySQLStatement
 *
 * @author gdievart <dievartg@gmail.com>
 */
class MySQLStatement extends Statement 
{
    
    /**
     * @var MySQLStatement Ref 
     */
    protected $_MySQLStatement = null;
    
    /**
     * Init PDO
     * 
     * @param handle $resource
     */
    public function __construct($resource)
    {
        $this->_MySQLStatement = $resource;
    }
    
    
    /**
     * Return current row
     * 
     * @param string $type 
     */
    public function fetch($type = Statement::FETCH_ASSOC)
    {
        return $this->_getTypeStatement($type);
    }
    
    
    /**
     * Return all rows
     * 
     * @todo
     * @param string $type 
     */
    public function fetchAll($type = Statement::FETCH_ASSOC)
    {
        $rows = array();
        while($row = $this->fetch($type)) {
            $rows[] = $row;
        }
        
        return $rows;
    }
    
    
    /**
     * Return row
     * 
     * @param string $type
     * @return mixed
     */
    protected function _getTypeStatement($type)
    {
        switch($type) {
            case Statement::FETCH_OBJECT:
                $row = mysql_fetch_object($this->_MySQLStatement);
                break;
            case Statement::FETCH_NUM:
                $row = mysql_fetch_array($this->_MySQLStatement, MYSQL_NUM);
                break;
            case Statement::FETCH_ASSOC:
                $row = mysql_fetch_assoc($this->_MySQLStatement);
                break;
        }
        
        return $row;
    }
}
