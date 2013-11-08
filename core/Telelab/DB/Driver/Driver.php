<?php
namespace Telelab\DB\Driver;

/**
 * Abstract class driver
 *
 * @author gdievart <dievartg@gmail.com>
 */
interface Driver
{
    /**
     * Init driver
     *
     * @param  string      $host
     * @param  string      $dbname
     * @param  stirng      $user
     * @param  string      $password
     * @throws DBException
     */
    public function __construct($host, $dbname, $user, $password);

    /**
     * Execute query and return resultl
     *
     * @param string $query
     * @return
     */
    public function query($query);

    /**
     * Execute query and return row affected
     *
     * @param  string $query
     * @return int
     */
    public function exec($query);

    /**
     * Set charset
     *
     * @param string $charset
     */
    public function setCharset($charset);

    /**
     * Escape string
     *
     * @param  string $query
     * @return int
     */
    public function escape($query);

    /**
     * Get last id insert
     *
     * @return int
     */
    public function getLastIdInsert();

    /**
     * Create a new connection
     */
    public function reset();
}
