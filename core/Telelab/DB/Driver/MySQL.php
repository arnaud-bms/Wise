<?php
namespace Telelab\DB\Driver;

use Telelab\DB\Driver\MySQLStatement;
use Telelab\Logger\Logger;

/**
 * Connector to database
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class MySQL implements Driver
{
    /**
     * @var handle Ref to link
     */
    private $_link;

    /**
     * Init link MySQL
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

        $this->_initLink();
    }


    /**
     * Init link
     *
     * @param boolean $new New link
     */
    public function _initLink($new = false)
    {
        $this->_link = mysql_connect($this->_host, $this->_user, $this->_password, $new);
        mysql_select_db($this->_dbname, $this->_link);
    }


    /**
     * Execute query and return result
     *
     * @param string $query
     * @return MySQLStatement
     */
    public function query($query)
    {
        Logger::log('['.__CLASS__.'] '.$query, Logger::LOG_DEBUG);
        if ($resource = mysql_query($query, $this->_link)) {
            return new MySQLStatement($resource);
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

        if (mysql_query($query, $this->_link)) {
            return mysql_affected_rows();
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
        mysql_query('SET NAMES "'.$charset.'"');
    }


    /**
     * Execute query and return rows affected
     *
     * @param string $query
     * @return string
     */
    public function escape($string)
    {
        return "'".mysql_real_escape_string($string)."'";
    }


    /**
     * Get last id insert
     *
     * @return int
     */
    public function getLastIdInsert()
    {
        return mysql_insert_id($this->_link);
    }


    /**
     * Close connection with database
     */
    public function close()
    {
        mysql_close($this->_link);
    }


    /**
     * Set connection with database
     */
    public function reset()
    {
        $this->_initLink(true);
    }
}