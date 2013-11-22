<?php
namespace Wise\Db\Driver;

use Wise\Db\Driver\Statement;

/**
 * Class \Wise\Db\Driver\MySQLStatement
 *
 * @author gdievart <dievartg@gmail.com>
 */
class MysqlStatement extends Statement
{

    /**
     * Reference to the MySQLStatement
     *
     * @var MySQLStatement
     */
    protected $mySQLStatement = null;

    /**
     * {@inherit}
     */
    public function __construct($resource)
    {
        $this->mySQLStatement = $resource;
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
