<?php
namespace Wise\DB\Driver;

use Wise\DB\Driver\Statement;

/**
 * Class \Wise\DB\Driver\MySQLiStatement
 *
 * @author gdievart <dievartg@gmail.com>
 */
class MysqliStatement extends Statement
{

    /**
     * MySQLiStatement Reference
     *
     * @var MySQLiStatement
     */
    protected $mySQLiStatement = null;

    /**
     * {@inherit}
     */
    public function __construct($resource)
    {
        $this->mySQLiStatement = $resource;
    }

    /**
     * {@inherit}
     */
    public function fetch($type = Statement::FETCH_ASSOC)
    {
        return $this->getTypeStatement($type);
    }

    /**
     * {@inherit}
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
     * {@inherit}
     */
    protected function getTypeStatement($type)
    {
        switch ($type) {
            case Statement::FETCH_OBJECT:
                $row = $this->mySQLiStatement->fetch_object();
                break;
            case Statement::FETCH_NUM:
                $row = $this->mySQLiStatement->fetch_array();
                break;
            case Statement::FETCH_ASSOC:
                $row = $this->mySQLiStatement->fetch_assoc();
                break;
        }

        return $row;
    }
}
