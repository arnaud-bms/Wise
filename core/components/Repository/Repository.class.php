<?php
namespace Telco\Repository;

use Telco\Component\Component;
use Telco\DB\DB;

/**
 * Default method to request database
 *
 * @author gdievart <dievartg@gmail.com>
 */
abstract class Repository extends Component
{
    /**
     * @var DB 
     */
    protected $_db;
    
    
    /**
     * Init repository
     * 
     * @param type $config 
     */
    public function _init($config)
    {
        $this->_db = DB::getInstance();
    }
    
    /**
     * Insert row into table
     *
     * @param array $rows
     * @param bool  $ignore
     */
    public function insert($rows, $ignore = false) 
    {
        $rows   = (array)$rows;
        $query  = "INSERT %s INTO %s (%s) VALUES(%s)";
        $ignore = $ignore ? 'IGNORE' : '';
        $fields = array_keys($rows);
        $values = $this->escapeValues($rows);

        $query = sprintf($query,
            $ignore,
            $this->_table,
            implode(',', $fields),
            implode(',', $values));

        return $this->_db->exec($query);
    }


    /**
    * Update rows table
    *
    * @param array $rows
    * @param array $where
    * @param bool  $ignore
    */
    public function update($rows, $where = array(), $ignore = false) 
    {
        $query  = "UPDATE %s %s SET %s WHERE %s";
        $ignore = $ignore ? 'IGNORE' : '';

        $setQuery   = $this->_queryAssign($rows, ',');
        $whereQuery = $this->_queryAssign($where, 'AND');

        $query = sprintf($query, $ignore, $this->_table, $setQuery, $whereQuery);

        return $this->_db->exec($query);
    }


    /**
    * Delete from table
    *
    * @param array $where
    */
    public function delete($where = array())
    {
        $query = "DELETE FROM %s WHERE %s";

        $whereQuery = $this->_queryAssign($where, 'AND');
        $query = sprintf($query,
            $this->_table,
            $whereQuery);

        return $this->_db->exec($query);
    }


    /**
    * Simple select on table
    *
    * @param array $select
    * @param array $where
    * @return 
    */
    public function select($select, $where = array(), $limit = null) 
    {
        $query = "SELECT %s FROM %s WHERE %s";

        $selectQuery = '';
        foreach((array)$select as $alias => $field) {
            if(!is_int($alias)) {
                $selectQuery.= $field.' as '.$alias.',';
            } else {
                $selectQuery.= $field.',';
            }
        }
        $selectQuery = rtrim($selectQuery, ',');

        if(count($where) > 0) {
            $whereQuery = $this->_queryAssign($where, 'AND');
        } else {
            $whereQuery = '1';
        }

        $query = sprintf($query, $selectQuery,
                    $this->_table,
                    $whereQuery);
        
        $query.= $limit !== null ? ' LIMIT '.$limit : null;

        return $this->_db->query($query);
    }


    /**
    * Construct field = value $sep
    *
    * @param array $value
    * @param string $separator
    */
    protected function _queryAssign($values, $separator) 
    {
        $query = '';
        foreach($values as $field => $value) {
            if($value[0] === '!') {
                $value = substr($value, 1);
                $operator = '!=';
            } else {
                $operator = '=';
            }

            $query.= $field.' '.$operator.' '.$this->escape($value).' '.$separator.' ';
        }

        return rtrim($query, $separator.' ');
    }


    /**
     * Escape list values
     *
     * @param array $valueList
     * @return array
     */
    public function escapeValues($valueList) 
    {
        foreach($valueList as &$value) {
            $value = $this->escape($value);
        }

        return $valueList;
    }


    /**
     * Escape value if is string
     *
     * @param mixed $value
     * @return mixed
     */
    public function escape($value) 
    {
        if(is_int($value) || is_float($value)) {
            return $value;
        }
        return $this->_db->escape($value);
    }
}
