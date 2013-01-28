<?php
namespace Telelab\DB\Driver;

use Telelab\DB\DBException;
use Telelab\DB\Driver\PDOStatement;
use Telelab\Logger\Logger;

/**
 * Connector to database
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class PDO implements Driver
{
    /**
     * @var PDO Ref to PDO
     */
    private $_pdo;

    /**
     * Init PDO Driver
     *
     * @param type $host
     * @param type $dbname
     * @param type $user
     * @param type $password
     * @throws DBException
     */
    public function __construct($host, $dbname, $user, $password)
    {
        $dsn      = sprintf('mysql:host=%s;dbname=%s;', $host, $dbname);
        try {
            $this->_pdo = new \PDO($dsn, $user, $password);
        } catch(\PDOException $e) {
            throw new DBException($e->getMessage(), $e->getCode());
        }
    }


    /**
     * Execute query and return result
     *
     * @param string $query
     * @return PDOStatement
     */
    public function query($query)
    {
        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_DEBUG);
        return new PDOStatement($this->_pdo->query($query));
    }


    /**
     * Execute query and return rows affected
     *
     * @param string $query
     * @return int
     */
    public function exec($query)
    {
        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_DEBUG);
        return $this->_pdo->exec($query);
    }


    /**
     * Execute query and return rows affected
     *
     * @param string $query
     * @return string
     */
    public function escape($string)
    {
        return $this->_pdo->quote($string);
    }


    /**
     * Get last id insert
     *
     * @return int
     */
    public function getLastIdInsert()
    {
        return $this->_pdo->lastInsertId();
    }


    /**
     * Close connection with database
     */
    public function close()
    {
        unset($this->_pdo);
    }


    /**
     * Close connection with database
     *
     * @todo
     */
    public function reset()
    {

    }
}