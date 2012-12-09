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
     * @var array $fieldChanged
     */
    private $_fieldChanged = array();

    /**
     * @var boolean Check if is new
     */
    private $_isNew = true;

    /**
     * @var mixed string or array for multiple keys
     */
    protected $_primaryKey = 'id';

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
     * Get value
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->_field)) {
            return $this->_field[$key];
        }

        return null;
    }


    /**
     * Set value
     *
     * @param string $key
     * @param string $value
     */
    public function __set($key, $value)
    {
        if (!array_key_exists($key, $this->_field) || $value !== $this->_field[$key]) {
            $this->_fieldChanged[$key] = $value;
        }
    }


    /**
     * Retrieve all properties of the entity in array
     *
     * @return array
     */
    public function getAll()
    {
        return $this->_field;
    }


    /**
     * Save insert or update entity
     *
     * @param boolean $setPrimaryKey Set primary_key after insert
     * @return boolean
     */
    public function save($setPrimaryKey = false, $criteria = array())
    {
        if ($this->_isNew) {
            $rowAffected = $this->_sqlBuilder->insert($this->_field);
            if ($rowAffected > 0 && $setPrimaryKey) {
                $this->_field[$this->_primaryKey] = $this->_sqlBuilder->getLastIdInsert();
            }
        } else {
            if (empty($criteria)) {
                $primaryKey = (array)$this->_primaryKey;
                foreach ($primaryKey as $key) {
                    $criteria[$key] = $this->_field[$key];
                }
            }

            $rowAffected = $this->_sqlBuilder->update($this->_fieldChanged, $criteria);
        }

        return $rowAffected;
    }


    /**
     * Set flag new
     *
     * @param boolean $isNew
     */
    public function setIsNew($isNew)
    {
        $this->_isNew = (boolean)$isNew;
    }
}
