<?php
namespace Telelab\DB\Driver;

use Telelab\DB\Driver\Statement;

/**
 * Description of PDOStatement
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class PDOStatement extends Statement
{

    /**
     * @var PDOStatement Ref
     */
    protected $_pdoStatement = null;

    /**
     * Init PDO
     *
     * @param PDOStatement $pdoStatement
     */
    public function __construct(\PDOStatement $pdoStatement)
    {
        $this->_pdoStatement = $pdoStatement;
    }


    /**
     * Return current row
     *
     * @param string $type
     * @return mixed Result of the current request
     */
    public function fetch($type = Statement::FETCH_ASSOC)
    {
        return $this->_getTypeStatement($type);
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
     * Return PDO::FETCH_*
     *
     * @param string $type
     * @return mixed
     */
    protected function _getTypeStatement($type)
    {
        switch($type) {
            case Statement::FETCH_OBJECT:
                $pdoFetch = \PDO::FETCH_OBJ;
                break;
            case Statement::FETCH_NUM:
                $pdoFetch = \PDO::FETCH_NUM;
                break;
            case Statement::FETCH_ASSOC:
                $pdoFetch = \PDO::FETCH_ASSOC;
                break;
        }

        return $pdoFetch;
    }
}
