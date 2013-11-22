<?php
namespace Wise\Db\Driver;

use Wise\Db\Driver\MysqliStatement;

/**
 * Class \Wise\Db\Driver\MySQLi
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Mysqli implements Db
{
    /**
     * Reference to the connection
     *
     * @var MySQLi
     */
    private $mysqli;

    /**
     * Host of the database
     *
     * @var string
     */
    private $host;

    /**
     * Database
     *
     * @var string
     */
    private $dbname;

    /**
     * User
     *
     * @var string
     */
    private $user;

    /**
     * Password
     *
     * @var string
     */
    private $password;

    /**
     * {@inherit}
     */
    public function __construct($host, $Dbname, $user, $password)
    {
        $this->host     = $host;
        $this->dbname   = $Dbname;
        $this->user     = $user;
        $this->password = $password;

        $this->initLink();
    }

    /**
     * {@inherit}
     */
    private function initLink()
    {
        $this->mysqli = new \mysqli($this->host, $this->user, $this->password, $this->dbname);
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
    public function error()
    {
        return $this->mysqli->error;
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
    public function ping()
    {
        if (false === $this->mysqli->ping()) {
            $this->initLink();
        }

        return true;
    }

    /**
     * {@inherit}
     */
    public function reset()
    {
        $this->initLink();
    }
}
