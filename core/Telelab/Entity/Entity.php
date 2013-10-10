<?php
namespace Telelab\Entity;

use Telelab\Component\Component;
use Telelab\SqlBuilder\SqlBuilder;
use Telelab\Str\Str;
use Telelab\Criteria\Criteria;

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
    protected $_tableName;

    /**
     * @var SqlBuilder
     */
    protected $_sqlBuilder;

    /**
     * @var array $field
     */
    protected $_field = array();

    /**
     * @var array $fieldChanged
     */
    protected $_fieldChanged = array();

    /**
     * @var boolean Check if is new
     */
    protected $_isNew = true;

    /**
     * @var mixed string or array for multiple keys
     */
    protected $_primaryKey = 'id';


    /**
     * Init members of DAO
     *
     * @param array $row Null if is a new row
     */
    protected function _init($row = null)
    {
        $this->_initTableName();
        if ($row !== null && is_array($row)) {
            $this->_isNew = false;
            $this->_hydrate($row);
        }

        $this->_sqlBuilder = new SqlBuilder($this->_tableName);
    }


    /**
     * Init properties of DAO
     *
     * @param array $row
     */
    protected function _hydrate($row)
    {
        foreach ($row as $key => $value) {
            $this->_field[$key] = $value;
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
        } elseif (array_key_exists($key, $this->_fieldChanged)) {
            return $this->_fieldChanged[$key];
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
        if (!array_key_exists($key, $this->_field) || ((string)$value !== $this->_field[$key]) && $value !== $this->_field[$key]) {
            $this->_fieldChanged[$key] = is_object($value) ? (string)$value : $value;
        }
    }


    /**
     * Handle getter and setter method calls
     *
     * @param string $method
     * @param array $argv
     */
    public function __call($method, $argv)
    {
        $prefix = substr($method, 0, 3);
        $key = Str::camelcaseToUnderscores(substr($method, 3));

        if ($prefix === 'get') {
            if (array_key_exists($key, $this->_field)) {
                return $this->_field[$key];
            } else {
                return null;
            }
        } elseif ($prefix === 'set') {
            $this->_fieldChanged[$key] = $argv[0];
        } else {
            throw new \Exception("Undefined method '$method'");
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
            $rowAffected = $this->_sqlBuilder->insert($this->_fieldChanged);
            if ($rowAffected > 0 && $setPrimaryKey) {
                $this->_fieldChanged[$this->getPrimaryKey()] = $this->_sqlBuilder->getLastIdInsert();
            }
            $this->_isNew = false;
            $this->_field = $this->_fieldChanged;
        } else {
            if (empty($criteria)) {
                $primaryKey = (array)$this->getPrimaryKey();
                foreach ($primaryKey as $key) {
                    $criteria[$key] = $this->_field[$key];
                }
            }
            
            if (!empty($this->_fieldChanged)) {
                $rowAffected = $this->_sqlBuilder->update($this->_fieldChanged, $criteria);
                foreach ($this->_fieldChanged as $newField => $value) {
                    $this->_field[$newField] = $value;
                }
            } else {
                $rowAffected = 0;
            }
        }

        $this->_fieldChanged = array();

        return $rowAffected;
    }


    /**
     * Delete entity
     *
     * @return int Number of rows affected
     */
    public function delete()
    {
        $criteria = new Criteria();
        $primaryKey = (array)$this->getPrimaryKey();
        foreach ($primaryKey as $key) {
            $criteria->add($key, $this->_field[$key], Criteria::EQUAL);
        }

        return $this->_sqlBuilder->delete($criteria);
    }


    /**
     * Check if the entity has changed
     *
     * @return boolean
     */
    public function hasChanged()
    {
        return !empty($this->_fieldChanged);
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


    /**
     * Get repository class name
     *
     * @return string
     */
    public function getRepositoryClass()
    {
        return str_replace('Entity', 'Repository', get_called_class());
    }


    /**
     * Get table primary key
     *
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->_primaryKey;
    }
}