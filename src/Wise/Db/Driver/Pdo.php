<?php
namespace Wise\Db\Driver;

use Wise\Db\Exception;
use Wise\Db\Driver\PdoStatement;

/**
 * Class \Wise\Db\Driver\PDO
 *
 * @author gdievart <dievartg@gmail.com>
 */
class Pdo implements Db
{
    /**
     * Reference to the connection
     *
     * @var PDO
     */
    private $pdo;

    /**
     * Host of the database
     *
     * @var string
     */
    private $host;

    /**
     * Database
     *
     * @var string
     */
    private $dbname;

    /**
     * User
     *
     * @var string
     */
    private $user;

    /**
     * Password
     *
     * @var string
     */
    private $password;

    /**
     * {@inherit}
     */
    public function __construct($host, $dbname, $user, $password)
    {
        $this->host     = $host;
        $this->dbname   = $dbname;
        $this->user     = $user;
        $this->password = $password;

        $this->initLink();
    }

    /**
     * {@inherit}
     */
    private function initLink()
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;', $this->host, $this->dbname);
        try {
            $this->pdo = new \PDO($dsn, $this->user, $this->password);
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
    public function error()
    {
        return implode(' ', $this->pdo->errorInfo());
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
     */
    public function ping()
    {
        if (false === $this->query('SELECT 1')) {
            $this->initLink();
        }

        return true;
    }

    /**
     * {@inherit}
     * @todo
     */
    public function reset()
    {

    }
}
