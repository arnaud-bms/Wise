<?php
namespace Telelab\Repository;

use Telelab\Component\Component;
use Telelab\SqlBuilder\SqlBuilder;

/**
 * Default method to request database
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Repository extends Component
{


    /**
     * Init repository
     *
     * @param type $config
     */
    public function _init($config)
    {
        $this->_sqlBuilder = new SqlBuilder($this->_table);
    }


    /**
     * Find entity by id
     *
     * @param int $id
     */
    public function find($id)
    {
        $where = array('id' => (int)$id);
        $stmt = $this->_sqlBuilder->select('*', $where, 1);
        return $stmt->fetch();
    }
}
