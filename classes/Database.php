<?php

namespace classes;

class Database
{
    public $db;
    private $username;
    private $password;
    private $dbname;

    public function __construct($Username, $Password, $Dbname)
    {
        $this->username = $Username;
        $this->password = $Password;
        $this->dbname = $Dbname;
        $option = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
        $this->db = new \PDO("mysql:host=localhost;dbname=$this->dbname", $this->username, $this->password, $option);
    }

    public function doing($sql, $value = [], $type = 'insert')
    {
        $result = $this->db->prepare($sql);
        foreach ($value as $key => $data) {
            $result->bindValue($key + 1, $data);
        }
        if ($type == 'insert') {
            return $result->execute();
        } else {
            $result->execute();
            if ($result->rowCount() >= 1) {
                return $result;
            } else {
                return false;
            }
        }
    }

    public function selection($sql, $value = [], $type = 'fetchall')
    {
        $result = $this->db->prepare($sql);
        foreach ($value as $key => $data) {
            $result->bindValue($key + 1, $data);
        }
        $result->execute();
        if ($type == 'fetchall') {
            if ($result->rowCount() >= 1) {
                $row = $result->fetchAll(\PDO::FETCH_OBJ);
                return $row;
            } else {
                return false;
            }
        } else {
            if ($result->rowCount() >= 1) {
                $row = $result->fetch(\PDO::FETCH_OBJ);
                return $row;
            } else {
                return false;
            }
        }
    }
}


