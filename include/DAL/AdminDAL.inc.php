<?php
require_once(dirname(__FILE__) . '/../../conf/config.php');

/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/3/25
 * Time: 20:56
 */
class AdminDAL
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

    public function GetAdminList($condition = array('id' => NULL, 'username' => NULL, 'permission' => NULL), $page = NULL)
    {
        $sql = 'SELECT * FROM `admin` WHERE 1 ';
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

    public function GetAdminOne($condition = array('id' => NULL, 'username' => NULL))
    {
        $sql = 'SELECT * FROM `admin` WHERE 1 ';
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

    public function CreateAdmin($condition = array('username' => NULL, 'password' => NULL, 'salt' => NULL, 'permission' => NULL))
    {
        $sql = "INSERT INTO `admin` (`username`,`password`,`salt`,`permission`) VALUES (:username,:password,:salt,:permission)";
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

    public function UpdateAdmin($condition = array('id' => NULL, 'username' => NULL), $information = array('username' => NULL, 'password' => NULL, 'salt' => NULL, 'permission' => NULL, 'logintime' => NULL, 'loginip' => NULL))
    {
        $sql = 'UPDATE `admin` SET ';
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

    public function DeleteAdmin($condition = array('id' => NULL, 'username' => NULL, 'permission' => NULL))
    {
        $sql = 'DELETE FROM `admin` WHERE 1 ';
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