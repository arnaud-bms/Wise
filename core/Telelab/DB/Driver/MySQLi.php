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
    private $mysqli;

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
        $this->_host     = $host;
        $this->_dbname   = $dbname;
        $this->_user     = $user;
        $this->_password = $password;
        
        $this->initLink();
    }

    
    /**
     * Init link
     *
     * @param boolean $new New link
     */
    private function initLink()
    {
        $this->mysqli = new \mysqli($this->_host, $this->_user, $this->_password, $this->_dbname);
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
        if ($resource = $this->mysqli->query($query)) {
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
        if ($this->mysqli->query($query)) {
            return $this->mysqli->affected_rows;
        }

        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_ERROR);

        return 0;
    }
    
    
    /**
     * Set charset
     * 
     * @param string $charset
     */
    public function setCharset($charset)
    {
        $this->mysqli->set_charset($charset);
    }


    /**
     * Execute query and return rows affected
     *
     * @param string $query
     * @return string
     */
    public function escape($string)
    {
        return "'".$this->mysqli->real_escape_string($string)."'";
    }


    /**
     * Get last id insert
     *
     * @return int
     */
    public function getLastIdInsert()
    {
        return $this->mysqli->insert_id;
    }


    /**
     * Close connection with database
     */
    public function close()
    {
        $this->mysqli->close();
    }

    
    /**
     * Set connection with database
     */
    public function reset()
    {
        $this->initLink();
    }
}
