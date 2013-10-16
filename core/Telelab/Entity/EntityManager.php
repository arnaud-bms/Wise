<?php
namespace Telelab\Entity;

use Telelab\Component\Component;
use Telelab\SqlBuilder\SqlBuilder;

/**
 * Entity
 *
 * @author gdievart <dievartg@gmail.com>
 */
class EntityManager extends Component
{
    /**
     * @var array Ref to entity
     */
    private $entities = array();

    /**
     * @var SqlBuilder
     */
    private $sqlBuilder;

    /**
     * Init members of DAO
     *
     * @param array $row
     */
    protected function init($row)
    {
        $this->hydrate($row);
        $this->sqlBuilder = new SqlBuilder($this->_tableName);
    }


    /**
     * Create entity
     *
     * @param string $entityName
     * @return Entity
     */
    public function createEntity($entityName)
    {
        $entity = new $entityName;
        $this->entities[$entityName][] = $entity;

        return $entity;
    }


    /**
     * Save all entities
     */
    public function save()
    {
        /**
         * @todo Get all entities from array and do insert multique
         */
    }
}
