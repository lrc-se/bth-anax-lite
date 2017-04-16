<?php

namespace LRC\Database;

/**
 * Database connection class.
 */
class DbConnection implements \Anax\Common\ConfigureInterface
{
    use \Anax\Common\ConfigureTrait;
    
    private $db;
    
    
    /**
     * Returns an active database connection, creating it if none exists.
     *
     * @return  \PDO    The connection as a PDO instance.
     */
    public function getConnection()
    {
        if (!isset($this->db)) {
            if (!isset($this->config)) {
                throw new Exception('No database configuration specified');
            }
            $this->db = new \PDO($this->config['dsn'], $this->config['user'], $this->config['pass']);
            $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            $this->db->exec('SET NAMES utf8;');
        }
        return $this->db;
    }
    
    /**
     * Executes an SQL statement with optional parameters.
     *
     * @param   string          $sql    The SQL statement.
     * @param   array           $params Array containing prepared statement parameters.
     * @throws  \PDOException           If the statement could not be executed.
     * @return  \PDOStatement           The PDO statement object.
     */
    public function execute($sql, $params = [])
    {
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) {
            throw new \PDOException("Could not prepare statement: $sql");
        }
        if (!$stmt->execute(is_array($params) ? $params : [$params])) {
            throw new \PDOException("Could not execute statement: $sql");
        }
        return $stmt;
    }
    
    /**
     * Executes an SQL query with optional parameters and returns the result set as an array.
     *
     * @param   string          $sql    The SQL statement.
     * @param   array           $params Array containing prepared statement parameters.
     * @param   string          $class  The class to instantiate the result objects as, if any.
     * @throws  \PDOException           If the statement could not be executed.
     * @return  array                   An array containing the result set.
     */
    public function query($sql, $params = [], $class = null)
    {
        $stmt = $this->execute($sql, $params);
        if (!is_null($class)) {
            $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
        }
        return $stmt->fetchAll();
    }
    
    /**
     * Executes an SQL query with optional parameters and returns the first result as an object.
     *
     * @param   string          $sql    The SQL statement.
     * @param   array           $params Array containing prepared statement parameters.
     * @param   string          $class  The class to instantiate the result object as, if any.
     * @throws  \PDOException           If the statement could not be executed.
     * @return  object|null             An object containing the first result, or null if no results were returned.
     */
    public function queryOne($sql, $params = [], $class = null)
    {
        $res = $this->query($sql, $params, $class);
        return (is_array($res) && count($res) > 0 ? $res[0] : null);
    }
    
    /**
     * Executes an SQL non-query statement with optional parameters and returns the number of rows affected.
     *
     * @param   string          $sql    The SQL statement.
     * @param   array           $params Array containing prepared statement parameters.
     * @throws  \PDOException           If the statement could not be executed.
     * @return  int                     Number of affected rows.
     */
    public function update($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->rowCount();
    }
    
    /**
     * Returns the last auto-generated insert ID.
     *
     * $return  string  The ID as provided by the database.
     */
    public function getInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }
}
