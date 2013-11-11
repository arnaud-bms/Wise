<?php
namespace Wise\DB\Driver;

/**
 * AbstractClass \Wise\DB\Driver\Statement
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Statement
{
    const FETCH_OBJECT = 0;
    const FETCH_NUM    = 1;
    const FETCH_ASSOC  = 2;

    abstract public function fetch($type);
    abstract public function fetchAll($type);
}
