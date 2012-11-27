<?php
namespace Telelab\DB\Driver;

/**
 * Statement query
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Statement
{
    const FETCH_OBJECT = 0;
    const FETCH_NUM    = 1;
    const FETCH_ASSOC  = 2;

    abstract function fetch($type);
    abstract function fetchAll($type);
}
