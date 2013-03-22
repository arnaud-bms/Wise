<?php
namespace Telelab\DB\Driver;

use Telelab\DB\Driver\MySQLiStatement;
use Telelab\Logger\Logger;

/**
 * Connector to database
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class MySQLi implements Driver
{
    /**
     * @var handle Ref to MySQLi
     */
    private $_mysqli;

    /**
     * Init MySQLi Driver
     *
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     */
    public function __construct($host, $dbname, $user, $password)
    {
        $this->_mysqli = new \mysqli($host, $user, $password, $dbname);
    }


    /**
     * Execute query and return result
     *
     * @param string $query
     * @return MySQLiStatement
     */
    public function query($query)
    {
        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_DEBUG);
        if ($resource = $this->_mysqli->query($query)) {
            return new MySQLiStatement($resource);
        }

        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_ERROR);

        return false;
    }


    /**
     * Execute query and return rows affected
     *
     * @param string $query
     * @return int Rows affected
     */
    public function exec($query)
    {
        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_DEBUG);
        if ($this->_mysqli->query($query)) {
            return $this->_mysqli->affected_rows;
        }

        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_ERROR);

        return 0;
    }


    /**
     * Execute query and return rows affected
     *
     * @param string $query
     * @return string
     */
    public function escape($string)
    {
        return "'".$this->_mysqli->real_escape_string($string)."'";
    }


    /**
     * Get last id insert
     *
     * @return int
     */
    public function getLastIdInsert()
    {
        return $this->_mysqli->insert_id;
    }


    /**
     * Close connection with database
     */
    public function close()
    {
        $this->_mysqli->close();
    }

    /**
     * Set connection with database
     * @todo
     */
    public function reset()
    {

    }
}