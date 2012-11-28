<?php
namespace Telelab\Entity;

use Telelab\Component\Component;
use Telelab\SqlBuilder\SqlBuilder;

/**
 * Entity
 *
 * @author gdievart <g.dievart@telemaque.fr>
 */
class EntityManager extends Component
{
    /**
     * @var array Ref to entity
     */
    private $_entities = array();

    /**
     * @var SqlBuilder
     */
    private $_sqlBuilder;

    /**
     * Init members of DAO
     *
     * @param array $row
     */
    protected function _init($row)
    {
        $this->_hydrate($row);
        $this->_sqlBuilder = new SqlBuilder($this->_tableName);
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
        $this->_entities[$entityName][] = $entity;

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
