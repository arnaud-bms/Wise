<?php
namespace Wise\DB\Driver;

use Wise\DB\Exception;
use Wise\DB\Driver\PdoStatement;

/**
 * Class \Wise\DB\Driver\PDO
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Pdo implements DB
{
    /**
     * Reference to the connection
     *
     * @var PDO
     */
    private $pdo;

    /**
     * {@inherit}
     */
    public function __construct($host, $dbname, $user, $password)
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;', $host, $dbname);
        try {
            $this->pdo = new \PDO($dsn, $user, $password);
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * {@inherit}
     */
    public function query($query)
    {
        if ($resource = $this->pdo->query($query)) {
            return new PdoStatement($resource);
        }

        return false;
    }

    /**
     * {@inherit}
     */
    public function exec($query)
    {
        if ($resource = $this->pdo->exec($query)) {
            return $resource;
        }

        return false;
    }

    /**
     * {@inherit}
     */
    public function setCharset($charset)
    {
        $this->pdo->exec('SET NAMES "'.$charset.'"');
    }

    /**
     * {@inherit}
     */
    public function escape($string)
    {
        return $this->pdo->quote($string);
    }

    /**
     * {@inherit}
     */
    public function getLastIdInsert()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * {@inherit}
     */
    public function close()
    {
        unset($this->pdo);
    }

    /**
     * {@inherit}
     * @todo
     */
    public function reset()
    {

    }
}
