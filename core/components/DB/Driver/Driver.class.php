<?php
namespace Telco\DB\Driver;


/**
 * Abstract class driver
 *
 * @author gdievart
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
}