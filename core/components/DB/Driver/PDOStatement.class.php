<?php
namespace Telco\DB\Driver;

use Telco\DB\Driver\Statement;

/**
 * Description of PDOStatement
 *
 * @author gdievart <dievartg@gmail.com>
 */
class PDOStatement extends Statement 
{
    
    /**
     * @var PDOStatement Ref 
     */
    protected $_PDOStatement = null;
    
    /**
     * Init PDO
     * 
     * @param PDOStatement $PDOStatement
     */
    public function __construct(\PDOStatement $PDOStatement)
    {
        $this->_PDOStatement = $PDOStatement;
    }
    
    
    /**
     * Return current row
     * 
     * @param string $type 
     */
    public function fetch($type = Statement::FETCH_ASSOC)
    {
        return $this->_PDOStatement->fetch($this->_getTypeStatement($type));
    }
    
    
    /**
     * Return all rows
     * 
     * @param string $type 
     */
    public function fetchAll($type = Statement::FETCH_ASSOC)
    {
        return $this->_PDOStatement->fetchAll($this->_getTypeStatement($type));
    }
    
    
    /**
     * Return PDO::FETCH_*
     * 
     * @param string $type
     * @return string
     */
    protected function _getTypeStatement($type)
    {
        switch($type) {
            case Statement::FETCH_OBJECT:
                $PDOFetch = \PDO::FETCH_OBJ;
                break;
            case Statement::FETCH_NUM:
                $PDOFetch = \PDO::FETCH_NUM;
                break;
            case Statement::FETCH_ASSOC:
                $PDOFetch = \PDO::FETCH_ASSOC;
                break;
        }
        
        return $PDOFetch;
    }
}
