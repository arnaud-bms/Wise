<?php
namespace Wise\Db\Driver;

/**
 * Interface \Wise\Db\Driver\Db
 *
 * Interface must be used by the driver
 *
 * @author gdievart <dievartg@gmail.com>
 */
interface Db
{
    /**
     * Init driver
     *
     * @param  string    $host
     * @param  string    $dbname
     * @param  stirng    $user
     * @param  string    $password
     * @throws Exception
     */
    public function __construct($host, $dbname, $user, $password);

    /**
     * Execute the sql query
     *
     * @param  string                    $query
     * @return \Wise\Db\Driver\Statement
     */
    public function query($query);

    /**
     * Execute the sql query
     *
     * @param  string $query
     * @return int    Rows affected by the query
     */
    public function exec($query);

    /**
     * Return the last error generated
     *
     * @return string Last error
     */
    public function error();

    /**
     * Set the charset
     *
     * @param string $charset
     */
    public function setCharset($charset);

    /**
     * Escape the string
     *
     * @param  string $query
     * @return int
     */
    public function escape($query);

    /**
     * Get last id inserted
     *
     * @return int
     */
    public function getLastIdInsert();

    /**
     * Ping the database, and reopen the connection if is closed
     *
     * @return boolean
     */
    public function ping();

    /**
     * Create a new connection
     */
    public function reset();
}
