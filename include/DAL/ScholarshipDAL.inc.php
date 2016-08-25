<?php

/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/5/16
 * Time: 22:07
 */
class ScholarshipDAL
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

    public function GetScholarshipList($condition = array('school' => NULL, 'major' => NULL, 'classid' => NULL, 'stuid' => NULL, 'name' => NULL, 'identification' => NULL, 'termid' => NULL, 'levelid' => NULL), $page = NULL)
    {
        $condition2 = array();
        $condition2['termid'] = $condition['termid'];
        $condition2['levelid'] = $condition['levelid'];
        unset($condition['termid']);
        unset($condition['levelid']);

        $subsql1 = "SELECT * FROM `student` WHERE 1 ";
        $subsql2 = "SELECT * FROM `v_scholarship_gainer_level` WHERE 1 ";

        foreach ($condition as $key => $value)
            if ($condition[$key] != NULL)
                $subsql1 .= "AND `$key`='$value' ";
        foreach ($condition2 as $key => $value)
            if ($condition2[$key] != NULL)
                $subsql2 .= "AND `$key`='$value' ";

        $sql = "SELECT * FROM ($subsql2) AS T1 LEFT JOIN ($subsql1) AS T2 ON T1.stuid=T2.stuid ";

        if ($page != NULL && is_numeric($page) && $page > 0) {
            $page -= 1;
            $sql .= "LIMIT $page,30 ";
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

    public function GetScholarshipOne($condition = array('stuid' => NULL, 'name' => NULL, 'identification' => NULL, 'termid' => NULL, 'levelid' => NULL))
    {
        $condition2 = array();
        $condition2['termid'] = $condition['termid'];
        $condition2['levelid'] = $condition['levelid'];
        unset($condition['termid']);
        unset($condition['levelid']);

        $subsql1 = "SELECT * FROM `student` WHERE 1 ";
        $subsql2 = "SELECT * FROM `v_scholarship_gainer_level` WHERE 1 ";

        foreach ($condition as $key => $value)
            if ($condition[$key] != NULL)
                $subsql1 .= "AND `$key`='$value' ";
        foreach ($condition2 as $key => $value)
            if ($condition[$key] != NULL)
                $subsql2 .= "AND `$key`='$value' ";

        $sql = "SELECT * FROM ($subsql1) AS T1 LEFT JOIN ($subsql2) AS T2 ON T1.stuid=T2.stuid ";

        $sqlp = $this->db->prepare($sql);
        if ($sqlp) {
            $sqlp->execute();
            $result = $sqlp->fetch();
            $sqlp->closeCursor();
            return $result;
        }
        return false;
    }

    public function SetGainer($condition = array('stuid' => NULL, 'termid' => NULL, 'levelid' => NULL))
    {
        $stuid = NULL;
        $termid = NULL;
        $levelid = NULL;
        $result = false;
        extract($condition);
        $sql_check = "SELECT * FROM `scholarship_gainer` WHERE `stuid`=$stuid AND `termid` = $termid";
        $sqlp_check = $this->db->prepare($sql_check);
        $sqlp_check->execute();
        $result = $sqlp_check->fetchAll();
        var_dump($result);
        if ($result) {
            $sql_set = "UPDATE `scholarship_gainer` SET `levelid`=$levelid WHERE `stuid`='$stuid' AND `termid`=$termid";
            $sqlp_set = $this->db->prepare($sql_set);
            $result = $sqlp_set->execute();
        } else {
            $sql_set = "INSERT INTO `scholarship_gainer` (`stuid`,`termid`,`levelid`) VALUES ('$stuid',$termid,$levelid)";
            $sqlp_set = $this->db->prepare($sql_set);
            $result = $sqlp_set->execute();
        }
        return $result;
    }

    public function UnsetGainer($condition = array('id' => NULL, 'stuid' => NULL, 'termid' => NULL,'levelid'=>NULL))
    {
        $id = NULL;
        $stuid = NULL;
        $termid = NULL;
        $result = false;
        extract($condition);
        $sql = "DELETE FROM `scholarship_gainer` WHERE 1 ";
        foreach ($condition as $key => $value)
            if ($condition[$key] != NULL)
                $sql .= "AND `$key`='$value' ";
        if ($id || !($stuid xor $termid)) {
            $sqlp = $this->db->prepare($sql);
            $result = $sqlp->execute();
        }

        return $result;
    }

    public function GetLevelList($condition = array('id' => NULL, 'levelname' => NULL), $page = NULL)
    {
        $sql = 'SELECT * FROM `scholarship_level` WHERE 1 ';
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

    public function GetLevelOne($condition = array('id' => NULL, 'levelname' => NULL))
    {
        $sql = 'SELECT * FROM `scholarship_level` WHERE 1 ';
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

    public function CreateLevel($condition = array('levelname' => NULL, 'money' => NULL, 'note' => NULL))
    {
        $sql = "INSERT INTO `scholarship_level` (`levelname`,`money`,`note`) VALUES (:levelname,:money,:note)";
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

    public function UpdateLevel($condition = array('id' => NULL, 'levelname' => NULL), $information = array('levelname' => NULL, 'money' => NULL, 'note' => NULL))
    {
        $sql = 'UPDATE `scholarship_level` SET ';
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

    public function DeleteLevel($condition = array('id' => NULL, 'levelname' => NULL))
    {
        $sql = 'DELETE FROM `scholarship_level` WHERE 1 ';
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

    public function GetTermList($condition = array('id' => NULL, 'title' => NULL, 'currenttime' => NULL, 'enabled' => NULL), $page = NULL)
    {
        $sql = 'SELECT * FROM `scholarship_term` WHERE 1 ';
        if ($condition['currenttime'] != NULL) {
            $currenttime = $condition['currenttime'];
            unset($condition['currenttime']);
            $sql .= "AND `starttime`<='$currenttime' AND `endtime`>= '$currenttime' ";
        }
        foreach ($condition as $key => $value)
            if ($condition[$key] != NULL)
                $sql .= "AND `$key`='$value'";
        if ($page != NULL && is_numeric($page) && $page > 0) {
            $page -= 1;
            $sql .= " LIMIT $page,30";
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

    public function GetTermOne($condition = array('id' => NULL, 'enabled' => NULL))
    {
        $sql = 'SELECT * FROM `scholarship_term` WHERE 1 ';
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

    public function CreateTerm($condition = array('title' => NULL, 'starttime' => NULL, 'endtime' => NULL, 'enabled' => NULL))
    {
        $sql = "INSERT INTO `scholarship_term` (`title`,`starttime`,`endtime`,`enabled`) VALUES (:title,:starttime,:endtime,:enabled)";
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

    public function UpdateTerm($condition = array('id' => NULL), $information = array('title' => NULL, 'starttime' => NULL, 'endtime' => NULL, 'enabled' => NULL))
    {
        $sql = 'UPDATE `scholarship_term` SET ';
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

    public function DeleteTerm($condition = array('id' => NULL))
    {
        $sql = 'DELETE FROM `scholarship_term` WHERE 1 ';
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