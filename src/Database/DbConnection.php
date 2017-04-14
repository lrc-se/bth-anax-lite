<?php

namespace LRC\Database;

class DbConnection implements \Anax\Common\ConfigureInterface
{
    use \Anax\Common\ConfigureTrait;
    
    private $db;
    
    
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
    
    public function execute($sql, $params = [])
    {
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) {
            throw new \PDOException('Could not prepare statement');
        }
        if (!$stmt->execute(is_array($params) ? $params : [$params])) {
            throw new \PDOException('Could not execute statement');
        }
        return ($stmt ?: null);
    }
    
    public function query($sql, $params = [], $class = null)
    {
        $stmt = $this->execute($sql, $params);
        if ($stmt) {
            if (!is_null($class)) {
                $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
            }
            return $stmt->fetchAll();
        }
        return null;
    }
    
    public function queryOne($sql, $params = [], $class = null)
    {
        $res = $this->query($sql, $params, $class);
        return (is_array($res) && count($res) > 0 ? $res[0] : null);
    }
    
    public function update($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return ($stmt ? $stmt->rowCount() : 0);
    }
    
    public function getInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }
}
