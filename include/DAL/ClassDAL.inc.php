<?php

/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/3/27
 * Time: 23:15
 */
class ClassDAL
{
    private $config;
    private $dsn;
    private $db;

    public function __construct()
    {
        $this->config = $cfg = new config();
        $this->dsn = "mysql:dbname=$cfg->dbname;host=$cfg->dbhost;port=$cfg->dbport";
        $this->db = new PDO($this->dsn, $cfg->dbuser, $cfg->dbpwd);
        $this->db->query("set names utf8");
    }

    public function GetClassList($condition = array('classid' => NULL, 'schoolid' => NULL, 'majorid' => NULL), $page = NULL)
    {
        $sql = 'SELECT * FROM `class` WHERE 1 ';
        foreach ($condition as $key => $value)
            if ($condition[$key] != NULL)
                $sql .= "AND `$key`='$value'";
        if ($page != NULL && is_numeric($page) && $page > 0) {
            $page -= 1;
            $sql .= "LIMIT $page,30";
        }
        $sqlp = $this->db->prepare($sql);
        if ($sqlp) {
            $sqlp->execute();
            $result = $sqlp->fetchAll();
            $sqlp->closeCursor();
            return $result;
        }
        return false;
    }

    public function GetClassOne($condition = array('classid' => NULL, 'schoolid' => NULL))
    {
        $sql = 'SELECT * FROM `class` WHERE 1 ';
        foreach ($condition as $key => $value)
            if ($condition[$key] != NULL)
                $sql .= "AND `$key`='$value'";
        $sqlp = $this->db->prepare($sql);
        if ($sqlp) {
            $sqlp->execute();
            $result = $sqlp->fetch();
            $sqlp->closeCursor();
            return $result;
        }
        return false;
    }

    public function CreateClass($condition = array('classid' => NULL, 'schoolid' => NULL, 'majorid' => NULL))
    {
        $sql = "INSERT INTO `class` (`classid`,`schoolid`,`majorid`) VALUES (:classid,:schoolid,:majorid)";
        $sqlp = $this->db->prepare($sql);
        $result = false;
        if ($sqlp) {
            foreach ($condition as $key => $value) {
                $sqlp->bindParam(':' . $key, $value);
            }
            $result = ($sqlp->execute($condition) && $sqlp->rowCount());
        }
        $sqlp->closeCursor();
        return $result;
    }

    public function UpdateClass($condition = array('classid' => NULL), $information = array('classid' => NULL, 'schoolid' => NULL, 'majorid' => NULL))
    {
        $sql = 'UPDATE `class` SET ';
        $datas = array();
        foreach ($information as $key => $value)
            if ($information[$key] != NULL) {
                $datas[] = "`$key`='$value'";
            }
        if (count($datas))
            $sql .= implode(',', $datas);
        $sql .= " WHERE 1 ";
        foreach ($condition as $key => $value)
            if ($condition[$key] != NULL)
                $sql .= "AND `$key`='$value'";
        $sqlp = $this->db->prepare($sql);
        if ($sqlp) {
            $sqlp->execute();
            $result = $sqlp->rowCount();
            $sqlp->closeCursor();
            return $result;
        } else {
            $sqlp->closeCursor();
            return false;
        }
    }

    public function DeleteClass($condition = array('classid' => NULL))
    {
        $sql = 'DELETE FROM `class` WHERE 1 ';
        foreach ($condition as $key => $value)
            if ($condition[$key] != NULL)
                $sql .= "AND `$key`='$value'";
        $sqlp = $this->db->prepare($sql);
        if ($sqlp) {
            $sqlp->execute();
            $result = $sqlp->rowCount();
            $sqlp->closeCursor();
            return $result;
        } else {
            $sqlp->closeCursor();
            return false;
        }
    }
}