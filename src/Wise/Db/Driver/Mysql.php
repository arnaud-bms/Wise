<?php
namespace Wise\Db\Driver;

use Wise\Db\Driver\MysqlStatement;

/**
 * Class \Wise\Db\Driver\MySQL
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Mysql implements Db
{
    /**
     * Link to the connection
     *
     * @var handle
     */
    private $link;

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
    public function __construct($host, $dbname, $user, $password)
    {
        $this->host     = $host;
        $this->dbname   = $dbname;
        $this->user     = $user;
        $this->password = $password;

        $this->initLink();
    }

    /**
     * {@inherit}
     */
    public function initLink($new = false)
    {
        $this->link = mysql_connect($this->host, $this->user, $this->password, $new);
        mysql_select_db($this->dbname, $this->link);
    }

    /**
     * {@inherit}
     */
    public function query($query)
    {
        if ($resource = mysql_query($query, $this->link)) {
            return new MysqlStatement($resource);
        }

        return false;
    }

    /**
     * {@inherit}
     */
    public function exec($query)
    {
        if (mysql_query($query, $this->link)) {
            return mysql_affected_rows();
        }

        return 0;
    }

    /**
     * {@inherit}
     */
    public function error()
    {
        return mysql_error($this->link);
    }

    /**
     * {@inherit}
     */
    public function setCharset($charset)
    {
        mysql_query('SET NAMES "'.$charset.'"');
    }

    /**
     * {@inherit}
     */
    public function escape($string)
    {
        return "'".mysql_real_escape_string($string)."'";
    }

    /**
     * {@inherit}
     */
    public function getLastIdInsert()
    {
        return mysql_insert_id($this->link);
    }

    /**
     * {@inherit}
     */
    public function close()
    {
        mysql_close($this->link);
    }

    /**
     * {@inherit}
     */
    public function ping()
    {
        if (false === mysql_ping($this->link)) {
            $this->initLink();
        }

        return true;
    }

    /**
     * {@inherit}
     */
    public function reset()
    {
        $this->initLink(true);
    }
}
