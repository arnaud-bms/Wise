<?php
namespace Telelab\Entity;

use Telelab\Component\Component;
use Telelab\SqlBuilder\SqlBuilder;

/**
 * Entity
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class Entity extends Component
{
    /**
     * @var string Table name of the entity
     */
    private $_tableName;

    /**
     * @var SqlBuilder
     */
    private $_sqlBuilder;

    /**
     * @var array $field
     */
    private $_field = array();

    /**
     * Init members of DAO
     *
     * @param array $row
     */
    protected function _init($row)
    {
        $this->_hydrate($row);
        $this->_initTableName();
        $this->_sqlBuilder = new SqlBuilder($this->_tableName);

    }


    /**
     * Init properties of DAO
     *
     * @param array $row
     */
    private function _hydrate($row)
    {
        if (is_array($row)) {
            foreach ($row as $key => $value) {
                $this->_field[$key] = $value;
            }
        }
    }


    /**
     * Init table name from entity
     */
    private function _initTableName()
    {
        if (!empty($this->_table)) {
            $this->_tableName = $this->_table;
        } else {
            preg_match('#([a-zA-Z]+)Entity$#', get_called_class(), $matches);
            $this->_tableName = strtolower($matches[1]);
        }
    }


    /**
     * Save insert or update entity
     *
     * @return boolean
     */
    public function save()
    {
        return $this->_sqlBuilder->insert($this->_field);
    }
}
