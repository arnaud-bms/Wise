<?php
namespace Telelab\Repository;

use Telelab\Component\Component;
use Telelab\SqlBuilder\SqlBuilder;

/**
 * Default method to request database
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
abstract class Repository extends Component
{

    /**
     * @var string Table name of the entity
     */
    private $_tableName;

    /**
     * @var boolean check if repository has entity
     */
    private $_hasEntity;

    /**
     * @var string entity class name
     */
    private $_entityName;


    /**
     * Init repository
     *
     * @param type $config
     */
    public function _init($config)
    {
        $this->_initEntity();
        $this->_initTableName();
        $this->_sqlBuilder = new SqlBuilder($this->_tableName);
    }


    /**
     * Check if entity DAO exists and set members
     */
    protected function _initEntity()
    {
        if ($this->_hasEntity === null) {
            $entityName        = str_replace('Repository', 'Entity', get_called_class());
            $this->_hasEntity  = class_exists($entityName);
            $this->_entityName = $entityName;
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
            preg_match('#([a-zA-Z]+)Repository$#', get_called_class(), $matches);
            $this->_tableName = strtolower($matches[1]);
        }
    }


    /**
     * Find entity by id
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        $where = array('id' => (int)$id);
        if ($stmt = $this->_sqlBuilder->select('*', $where, 1)) {
            return $this->_getEntity($stmt->fetch());
        }
        return false;
    }


    /**
     * Find all entities
     *
     * @return array List rows
     */
    public function findAll()
    {
        return $this->findBy(array());
    }


    /**
     * Find by dynamic
     *
     * @param array $criteria
     * @param array $order
     * @param int $limit
     * @param int $offset
     * @return array List rows
     */
    public function findBy($criteria, $order = null, $limit = null, $offset = null)
    {
        if ($stmt = $this->_sqlBuilder->select('*', $criteria, $order, $limit, $offset)) {
            $entities = array();
            while ($row = $stmt->fetch()) {
                $entities[] = $this->_getEntity($row);
            }

            return $entities;
        }

        return false;
    }


    /**
     * Find by dynamic
     *
     * @param array $criteria
     * @param array $order
     * return array List rows
     */
    public function findOneBy($criteria, $order = null)
    {
        if ($stmt = $this->_sqlBuilder->select('*', $criteria, $order, 1)) {
            return $this->_getEntity($stmt->fetch());
        }
        return false;
    }


    /**
     * Return count(*)
     *
     * @param array $criteria
     * @return int
     */
    public function count($criteria)
    {
        if ($stmt = $this->_sqlBuilder->select(array('nb' => 'count(*)'), $criteria)) {
            if($result = $stmt->fetch()) {
                return (int)$result['nb'];
            }

        }
        return false;
    }


    /**
     * Create find dynamic request
     *
     * @param string $method
     * @param array $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        switch ($method) {
            case (strpos($method, 'findBy')):
                $field  = strtolower(substr($method, 6));
                $method = 'findBy';
                break;
            case (strpos($method, 'findOneBy')):
                $field  = strtolower(substr($method, 9));
                $method = 'findBy';
                break;
                break;
            default:
                throw new RepositoryException("Method '$method' does'nt exists");
        }

        switch (count($argv)) {
            case 1:
                return $this->$method(array($field => $argv[0]));
            case 2:
                return $this->$method(array($field => $argv[0]), $argv[1]);
            case 3:
                return $this->$method(array($field => $argv[0]), $argv[1], $argv[2]);
            case 4;
                return $this->$method(array($field => $argv[0]), $argv[1], $argv[2], $argv[3]);
            default:
        }
    }


    /**
     * Create entity DAO if exists
     *
     * @param array $row
     * @return mixed
     */
    protected function _getEntity($row)
    {
        if ($row && $this->_hasEntity) {
            $row = new $this->_entityName($row);
        }

        return $row;
    }
}
