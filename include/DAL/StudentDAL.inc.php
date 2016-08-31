<?php
require_once(dirname(__FILE__) . '/../../conf/config.php');

/**
 * StudentDAL short summary.
 *
 * StudentDAL description.
 *
 * @version 1.0
 * @author Ain
 */
class StudentDAL
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

    public function GetStudentList($condition = array('school' => NULL, 'major' => NULL, 'classid' => NULL, 'stuid' => NULL, 'name' => NULL, 'identification' => NULL), $page = NULL)
    {
        $sql = 'SELECT * FROM `student` WHERE 1 ';
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

    public function GetStudentOne($condition = array('stuid' => NULL, 'name' => NULL, 'identification' => NULL))
    {
        $sql = 'SELECT * FROM `student` WHERE 1 ';
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

    public function CreateStudent($condition = array('stuid' => NULL, 'name' => NULL, 'identification' => NULL, 'sex' => NULL, 'birthday' => NULL, 'note' => NULL, 'classid' => NULL, 'major' => NULL, 'school' => NULL, 'insured' => NULL))
    {
        $sql = "INSERT INTO `student` (`stuid`,`name`,`identification`,`sex`,`birthday`,`note`,`classid`,`major`,`school`,`insured`) VALUES (:stuid,:name,:identification,:sex,:birthday,:note,:classid,:major,:school,:insured)";
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

    public function UpdateStudent($condition = array('stuid' => NULL, 'name' => NULL), $information = array('school' => NULL, 'major' => NULL, 'classid' => NULL, 'stuid' => NULL, 'name' => NULL, 'identification' => NULL, 'sex' => NULL, 'birthday' => NULL, 'note' => NULL, 'insured' => NULL))
    {
        $sql = 'UPDATE `student` SET ';
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

    public function DeleteStudent($condition = array('school' => NULL, 'major' => NULL, 'classid' => NULL, 'stuid' => NULL, 'name' => NULL, 'identification' => NULL))
    {
        $sql = 'DELETE FROM `student` WHERE 1 ';
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