<?php
namespace Telelab\DB\Driver;

use Telelab\DB\Driver\Statement;

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
    protected $_mySQLiStatement = null;

    /**
     * Init PDO
     *
     * @param handle $resource
     */
    public function __construct($resource)
    {
        $this->_mySQLiStatement = $resource;
    }


    /**
     * Return current row
     *
     * @param string $type
     */
    public function fetch($type = Statement::FETCH_ASSOC)
    {
        return $this->_mySQLiStatement->fetch($this->_getTypeStatement($type));
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
                $row = $this->_mySQLiStatement->fetch_object();
                break;
            case Statement::FETCH_NUM:
                $row = $this->_mySQLiStatement->fetch_array();
                break;
            case Statement::FETCH_ASSOC:
                $row = $this->_mySQLiStatement->fetch_assoc();
                break;
        }

        return $row;
    }
}
