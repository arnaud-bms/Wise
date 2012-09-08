<?php
namespace Telco\DB\Driver;

use Telco\DB\Driver\Statement;

/**
 * MySQLiStatement
 *
 * @author gdievart <dievartg@gmail.com>
 */
class MySQLiStatement extends Statement 
{
    
    /**
     * @var MySQLiStatement Ref 
     */
    protected $_MySQLiStatement = null;
    
    /**
     * Init PDO
     * 
     * @param handle $resource
     */
    public function __construct($resource)
    {
        $this->_MySQLiStatement = $resource;
    }
    
    
    /**
     * Return current row
     * 
     * @param string $type 
     */
    public function fetch($type = Statement::FETCH_ASSOC)
    {
        return $this->_MySQLiStatement->fetch($this->_getTypeStatement($type));
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
                $row = $this->_MySQLiStatement->fetch_object();
                break;
            case Statement::FETCH_NUM:
                $row = $this->_MySQLiStatement->fetch_array();
                break;
            case Statement::FETCH_ASSOC:
                $row = $this->_MySQLiStatement->fetch_assoc();
                break;
        }
        
        return $row;
    }
}
