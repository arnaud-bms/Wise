<?php
namespace Telco\DB\Driver;

use Iterator;

/**
 * Statement query
 *
 * @author gdievart
 */
abstract class Statement 
{
    
    const FETCH_OBJECT = 0;
    const FETCH_NUM    = 1;
    const FETCH_ASSOC  = 2;
    
    abstract function fetch($type);
    abstract function fetchAll($type);
}
