<?php
namespace Wise\DB\Driver;

use Wise\DB\Driver\MysqlStatement;

/**
 * Class \Wise\DB\Driver\MySQL
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Mysql implements DB
{
    /**
     * Link to the connection
     *
     * @var handle
     */
    private $link;

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
    public function initLink($new = false)
    {
        $this->link = mysql_connect($this->_host, $this->_user, $this->_password, $new);
        mysql_select_db($this->_dbname, $this->link);
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
    public function reset()
    {
        $this->initLink(true);
    }
}
