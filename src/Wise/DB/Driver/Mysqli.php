<?php
namespace Wise\DB\Driver;

use Wise\DB\Driver\MysqliStatement;

/**
 * Class \Wise\DB\Driver\MySQLi
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Mysqli implements DB
{
    /**
     * Reference to the connection
     *
     * @var MySQLi
     */
    private $mysqli;

    /**
     * {@inherit}
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
     * {@inherit}
     */
    private function initLink()
    {
        $this->mysqli = new \mysqli($this->_host, $this->_user, $this->_password, $this->_dbname);
    }

    /**
     * {@inherit}
     */
    public function query($query)
    {
        if ($resource = $this->mysqli->query($query)) {
            return new MysqliStatement($resource);
        }

        return false;
    }

    /**
     * {@inherit}
     */
    public function exec($query)
    {
        if ($this->mysqli->query($query)) {
            return $this->mysqli->affected_rows;
        }

        return 0;
    }

    /**
     * {@inherit}
     */
    public function setCharset($charset)
    {
        $this->mysqli->set_charset($charset);
    }

    /**
     * {@inherit}
     */
    public function escape($string)
    {
        return "'".$this->mysqli->real_escape_string($string)."'";
    }

    /**
     * {@inherit}
     */
    public function getLastIdInsert()
    {
        return $this->mysqli->insert_id;
    }

    /**
     * {@inherit}
     */
    public function close()
    {
        $this->mysqli->close();
    }

    /**
     * {@inherit}
     */
    public function reset()
    {
        $this->initLink();
    }
}
