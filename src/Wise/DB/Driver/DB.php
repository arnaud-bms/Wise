<?php
namespace Wise\DB\Driver;

/**
 * Interface \Wise\DB\Driver\DB
 *
 * Interface must be used by the driver
 *
 * @author gdievart <dievartg@gmail.com>
 */
interface DB
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
     * @return \Wise\DB\Driver\Statement
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
     * Create a new connection
     */
    public function reset();
}
