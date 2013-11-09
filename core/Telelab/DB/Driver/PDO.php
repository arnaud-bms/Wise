<?php
namespace Wise\DB\Driver;

use Wise\DB\DBException;
use Wise\DB\Driver\PDOStatement;
use Wise\Logger\Logger;

/**
 * Connector to database
 *
 * @author gdievart <dievartg@gmail.com>
 */
class PDO implements Driver
{
    /**
     * @var PDO Ref to PDO
     */
    private $pdo;

    /**
     * Init PDO Driver
     *
     * @param  type        $host
     * @param  type        $dbname
     * @param  type        $user
     * @param  type        $password
     * @throws DBException
     */
    public function __construct($host, $dbname, $user, $password)
    {
        $dsn      = sprintf('mysql:host=%s;dbname=%s;', $host, $dbname);
        try {
            $this->pdo = new \PDO($dsn, $user, $password);
        } catch (\PDOException $e) {
            throw new DBException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Execute query and return result
     *
     * @param  string       $query
     * @return PDOStatement
     */
    public function query($query)
    {
        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_DEBUG);
        if ($resource = $this->pdo->query($query)) {
            return new PDOStatement($resource);
        }

        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_ERROR);

        return false;
    }

    /**
     * Execute query and return rows affected
     *
     * @param  string $query
     * @return int
     */
    public function exec($query)
    {
        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_DEBUG);
        if ($resource = $this->pdo->exec($query)) {
            return $resource;
        }

        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_ERROR);

        return false;
    }

    /**
     * Set charset
     *
     * @param string $charset
     */
    public function setCharset($charset)
    {
        $this->pdo->exec('SET NAMES "'.$charset.'"');
    }

    /**
     * Execute query and return rows affected
     *
     * @param  string $query
     * @return string
     */
    public function escape($string)
    {
        return $this->pdo->quote($string);
    }

    /**
     * Get last id insert
     *
     * @return int
     */
    public function getLastIdInsert()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Close connection with database
     */
    public function close()
    {
        unset($this->pdo);
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
