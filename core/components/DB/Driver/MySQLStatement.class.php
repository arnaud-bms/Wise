<?php
namespace Telelab\DB\Driver;

use Telelab\DB\Driver\Statement;

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
    protected $_mySQLStatement = null;

    /**
     * Init PDO
     *
     * @param handle $resource
     */
    public function __construct($resource)
    {
        $this->_mySQLStatement = $resource;
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
        while ($row = $this->fetch($type)) {
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
                $row = mysql_fetch_object($this->_mySQLStatement);
                break;
            case Statement::FETCH_NUM:
                $row = mysql_fetch_array($this->_mySQLStatement, MYSQL_NUM);
                break;
            case Statement::FETCH_ASSOC:
                $row = mysql_fetch_assoc($this->_mySQLStatement);
                break;
        }

        return $row;
    }
}
