<?php
namespace Telelab\DB\Driver;

use Telelab\DB\Driver\Statement;

/**
 * MySQLStatement
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class MySQLStatement extends Statement
{

    /**
     * @var MySQLStatement Ref
     */
    protected $mySQLStatement = null;

    /**
     * Init PDO
     *
     * @param handle $resource
     */
    public function __construct($resource)
    {
        $this->mySQLStatement = $resource;
    }


    /**
     * Return current row
     *
     * @param string $type
     */
    public function fetch($type = Statement::FETCH_ASSOC)
    {
        return $this->getTypeStatement($type);
    }


    /**
     * Return all rows
     *
     * @param string $type
     * @return array List result
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
    protected function getTypeStatement($type)
    {
        switch($type) {
            case Statement::FETCH_OBJECT:
                $row = mysql_fetch_object($this->mySQLStatement);
                break;
            case Statement::FETCH_NUM:
                $row = mysql_fetch_array($this->mySQLStatement, MYSQL_NUM);
                break;
            case Statement::FETCH_ASSOC:
                $row = mysql_fetch_assoc($this->mySQLStatement);
                break;
        }

        return $row;
    }
}
