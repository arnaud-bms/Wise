<?php
namespace Telelab\DB\Driver;

/**
 * Statement query
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class Statement
{
    const FETCH_OBJECT = 0;
    const FETCH_NUM    = 1;
    const FETCH_ASSOC  = 2;

    abstract public function fetch($type);
    abstract public function fetchAll($type);
}
