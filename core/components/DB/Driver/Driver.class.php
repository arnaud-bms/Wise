<?php
namespace Telelab\DB\Driver;


/**
 * Abstract class driver
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
interface Driver
{
    /**
     * Init driver
     *
     * @param type $host
     * @param type $dbname
     * @param type $user
     * @param type $password
     * @throws DBException
     */
    public function __construct($host, $dbname, $user, $password);

    /**
     * Execute query and return resultl
     *
     * @param string  $query
     * @return
     */
    public function query($query);

    /**
     * Execute query and return row affected
     *
     * @param string  $query
     * @return int
     */
    public function exec($query);

    /**
     * Escape string
     *
     * @param string $query
     * @return int
     */
    public function escape($query);

    /**
     * Get last id insert
     *
     * @return int
     */
    public function getLastIdInsert();
}