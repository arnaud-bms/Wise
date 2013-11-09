<?php
namespace Wise\SqlBuilder;

use Wise\Component\Component;
use Wise\DB\DB;

/**
 * Build sql request
 *
 * @author gdievart <dievartg@gmail.com>
 */
class SqlBuilder extends Component
{
    /**
     * @var DB
     */
    protected $db;

    /**
     * @var string table name
     */
    protected $table;

    /**
     * Init repository
     *
     * @param type $config
     */
    public function init($table)
    {
        $this->table = $table;
        $this->db = DB::getInstance();
    }

    /**
     * Call method on DB
     *
     * @param  string $method
     * @param  array  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->db, $method), $args);
    }

    /**
     * Insert row into table
     *
     * @param array $rows
     * @param bool  $ignore
     */
    public function insert($rows, $ignore = false)
    {
        $rows   = (array) $rows;
        $query  = "INSERT %s INTO %s (%s) VALUES(%s)";
        $ignore = $ignore ? 'IGNORE' : '';
        $fields = array_keys($rows);
        $values = $this->escapeValues($rows);

        foreach ($fields as &$field) {
            $field = '`'.$field.'`';
        }

        $query = sprintf(
            $query,
            $ignore,
            $this->table,
            implode(',', $fields),
            implode(',', $values)
        );

        return $this->db->exec($query);
    }

    /**
     * Insert rows into table
     *
     * @param array $rows
     * @param bool  $ignore
     */
    public function insertMultiple($rows, $ignore = false)
    {
        if (empty($rows)) {
            return 0;
        }

        $query  = "INSERT %s INTO %s (%s) VALUES%s";
        $ignore = $ignore ? 'IGNORE' : '';
        $fields = array_keys(current($rows));

        $queryValues = '';
        foreach ($rows as $row) {
            $values = $this->escapeValues($row);
            $queryValues.= '('.implode(',', $values).'), ';
        }

        foreach ($fields as &$field) {
            $field = '`'.$field.'`';
        }

        $query = sprintf(
            $query,
            $ignore,
            $this->table,
            implode(',', $fields),
            rtrim($queryValues, ', ')
        );

        return $this->db->exec($query);
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

        $setQuery   = $this->queryAssign($rows, ',');
        $whereQuery = $this->queryAssign($where, 'AND');

        $query = sprintf($query, $ignore, $this->table, $setQuery, $whereQuery);

        return $this->db->exec($query);
    }

    /**
    * Delete from table
    *
    * @param array $where
    */
    public function delete($where = array())
    {
        $query = "DELETE FROM %s WHERE %s";

        $whereQuery = $this->queryAssign($where, 'AND');
        $query = sprintf(
            $query,
            $this->table,
            $whereQuery
        );

        return $this->db->exec($query);
    }

    /**
    * Simple select on table
    *
    * @param array $select
    * @param array $where
    * @param array $order
    * @return
    */
    public function select($select, $where = array(), $order = null, $limit = null, $offset = null)
    {
        $query = "SELECT %s FROM %s WHERE %s";

        $selectQuery = '';
        foreach ((array) $select as $alias => $field) {
            if (!is_int($alias)) {
                $selectQuery.= $field.' as '.$alias.',';
            } else {
                $selectQuery.= $field.',';
            }
        }
        $selectQuery = rtrim($selectQuery, ',');

        if (count($where) > 0) {
            $whereQuery = $this->queryAssign($where, 'AND');
        } else {
            $whereQuery = '1';
        }

        $query = sprintf($query, $selectQuery, $this->table, $whereQuery);

        /**
         * @todo Optimize order by
         */
        if (!empty($order)) {
            $query.= ' ORDER BY ';
            foreach ($order as $field => $way) {
                $query.= $field.' '.$way.', ';
            }
            $query = rtrim($query, ', ');
        }

        if ($limit !== null) {
            $query.= $offset !== null ? ' LIMIT '.(int) $offset.', '.(int) $limit : ' LIMIT '.(int) $limit;
        }

        return $this->db->query($query);
    }

    /**
    * Construct field = value $sep
    *
    * @param array $value
    * @param string $separator
    */
    protected function queryAssign($values, $separator)
    {
        $query = '';
        foreach ($values as $field => $value) {
            if (is_array($value)) {
                $value = array_map(array($this, 'escape'), $value);
                $query.= '`'.$field.'` IN('.implode(',', $value).')'.' '.$separator.' ';
            } elseif ($value === null) {
                $query.= '`'.$field.'` = NULL '.$separator.' ';
            } else {
                if (!empty($value) && $value[0] === '!') {
                    $value = substr($value, 1);
                    $operator = '!=';
                } else {
                    $operator = '=';
                }

                $query.= '`'.$field.'` '.$operator.' '
                       . $this->escape($value).' '.$separator.' ';
            }
        }

        return rtrim($query, $separator.' ');
    }

    /**
     * Escape list values
     *
     * @param  array $valueList
     * @return array
     */
    public function escapeValues($valueList)
    {
        foreach ($valueList as &$value) {
            $value = $this->escape($value);
        }

        return $valueList;
    }

    /**
     * Escape value if is string
     *
     * @param  mixed $value
     * @return mixed
     */
    public function escape($value)
    {
        if (is_int($value) || is_float($value)) {
            return $value;
        }

        return $this->db->escape($value);
    }

    /**
     * Reset connection with database
     */
    public function closeConnection()
    {
        $this->db->close();
    }
}
