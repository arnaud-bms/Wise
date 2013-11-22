<?php
namespace Wise\Db\Driver;

use Wise\Db\Driver\Statement;

/**
 * Class \Wise\Db\Driver\PDOStatement
 *
 * @author gdievart <dievartg@gmail.com>
 */
class PdoStatement extends Statement
{

    /**
     * Reference to PDOStatement
     *
     * @var reference
     */
    protected $pdoStatement = null;

    /**
     * {@inherit}
     */
    public function __construct(\PdoStatement $pdoStatement)
    {
        $this->pdoStatement = $pdoStatement;
    }

    /**
     * {@inherit}
     */
    public function fetch($type = Statement::FETCH_ASSOC)
    {
        return $this->pdoStatement->fetch($this->getTypeStatement($type));
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
