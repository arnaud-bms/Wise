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
    protected $tableName;

    /**
     * @var SqlBuilder
     */
    protected $sqlBuilder;

    /**
     * @var array $field
     */
    protected $field = array();

    /**
     * @var array $fieldChanged
     */
    protected $fieldChanged = array();

    /**
     * @var boolean Check if is new
     */
    protected $isNew = true;

    /**
     * @var mixed string or array for multiple keys
     */
    protected $primaryKey = 'id';


    /**
     * Init members of DAO
     *
     * @param array $row Null if is a new row
     */
    protected function init($row = null)
    {
        $this->initTableName();
        if ($row !== null && is_array($row)) {
            $this->isNew = false;
            $this->hydrate($row);
        }

        $this->sqlBuilder = new SqlBuilder($this->tableName);
    }


    /**
     * Init properties of DAO
     *
     * @param array $row
     */
    protected function hydrate($row)
    {
        foreach ($row as $key => $value) {
            $this->field[$key] = $value;
        }
    }


    /**
     * Init table name from entity
     */
    private function initTableName()
    {
        if (!empty($this->_table)) {
            $this->tableName = $this->_table;
        } else {
            preg_match('#([a-zA-Z]+)Entity$#', get_called_class(), $matches);
            $this->tableName = strtolower($matches[1]);
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
        if (array_key_exists($key, $this->field)) {
            return $this->field[$key];
        } elseif (array_key_exists($key, $this->fieldChanged)) {
            return $this->fieldChanged[$key];
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
        if (!array_key_exists($key, $this->field) || ((string)$value !== $this->field[$key]) && $value !== $this->field[$key]) {
            $this->fieldChanged[$key] = is_object($value) ? (string)$value : $value;
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
            if (array_key_exists($key, $this->field)) {
                return $this->field[$key];
            } else {
                return null;
            }
        } elseif ($prefix === 'set') {
            $this->fieldChanged[$key] = $argv[0];
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
        return $this->field;
    }


    /**
     * Save insert or update entity
     *
     * @param boolean $setPrimaryKey Set primary_key after insert
     * @return boolean
     */
    public function save($setPrimaryKey = false, $criteria = array())
    {
        if ($this->isNew) {
            $rowAffected = $this->sqlBuilder->insert($this->fieldChanged);
            if ($rowAffected > 0 && $setPrimaryKey) {
                $this->fieldChanged[$this->getPrimaryKey()] = $this->sqlBuilder->getLastIdInsert();
            }
            $this->isNew = false;
            $this->field = $this->fieldChanged;
        } else {
            if (empty($criteria)) {
                $primaryKey = (array)$this->getPrimaryKey();
                foreach ($primaryKey as $key) {
                    $criteria[$key] = $this->field[$key];
                }
            }
            
            if (!empty($this->fieldChanged)) {
                $rowAffected = $this->sqlBuilder->update($this->fieldChanged, $criteria);
                foreach ($this->fieldChanged as $newField => $value) {
                    $this->field[$newField] = $value;
                }
            } else {
                $rowAffected = 0;
            }
        }

        $this->fieldChanged = array();

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
            $criteria->add($key, $this->field[$key], Criteria::EQUAL);
        }

        return $this->sqlBuilder->delete($criteria);
    }


    /**
     * Check if the entity has changed
     *
     * @return boolean
     */
    public function hasChanged()
    {
        return !empty($this->fieldChanged);
    }


    /**
     * Set flag new
     *
     * @param boolean $isNew
     */
    public function setIsNew($isNew)
    {
        $this->isNew = (boolean)$isNew;
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
        return $this->primaryKey;
    }
}