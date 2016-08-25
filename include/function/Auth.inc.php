<?php
require_once dirname(__FILE__) . '/../DAL/TeacherDAL.inc.php';
require_once dirname(__FILE__).'/../DAL/AdminDAL.inc.php';
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/3/24
 * Time: 11:03
 */
class Auth
{
    public static function TeacherLogin($username, $password)
    {
        $tdal = new TeacherDAL();
        $tinfo['username'] = $username;
        $result = $tdal->GetTeacherOne($tinfo);
        if ($result) {
            $password = md5(md5($password) . $result['salt']);
            if ($result['password'] == $password) {
                $_SESSION['teacher_userid'] = $result['id'];
                $_SESSION['teacher_username'] = $result['username'];
                $_SESSION['teacher_operator'] = $result['operator'];
                $_SESSION['teacher_loginip'] = $result['loginip'];
                $_SESSION['teacher_logintime'] = $result['logintime'];
                $_SESSION['teacher_schoolid'] = $result['schoolid'];
                $tnewinfo = array();
                $tnewinfo['logintime'] = time();
                $tnewinfo['loginip'] = $_SERVER['REMOTE_ADDR'];
                $tdal->UpdateTeacher($tinfo, $tnewinfo);
                return true;
            }
        }
        return false;
    }

    public static function TeacherLogout()
    {
        unset($_SESSION['teacher_userid']);
        unset($_SESSION['teacher_username']);
        unset($_SESSION['teacher_operator']);
        unset($_SESSION['teacher_loginip']);
        unset($_SESSION['teacher_logintime']);
        unset($_SESSION['teacher_schoolid']);
    }

    public static function TeacherCheck()
    {
        if (isset($_SESSION['teacher_userid']) && isset($_SESSION['teacher_username']) && $_SESSION['teacher_userid'] && $_SESSION['teacher_username']) {
            $rnum = rand(0, 9);
            if ($rnum < 4) {
                $tdal = new TeacherDAL();
                $tinfo['id'] = $_SESSION['teacher_userid'];
                $result = $tdal->GetTeacherOne($tinfo);
                if ($result)
                    if ($result['username'] == $_SESSION['teacher_username'])
                        return true;
            } else if ($rnum >= 4) {
                return true;
            }
        }
        return false;
    }

    public static function AdminLogin($username, $password)
    {
        $adal = new AdminDAL();
        $ainfo['username'] = $username;
        $result = $adal->GetAdminOne($ainfo);
        if ($result) {
            $password = md5(md5($password) . $result['salt']);
            if ($result['password'] == $password) {
                $_SESSION['admin_userid'] = $result['id'];
                $_SESSION['admin_username'] = $result['username'];
                $_SESSION['admin_permission'] = $result['permission'];
                $_SESSION['admin_loginip'] = $result['loginip'];
                $_SESSION['admin_logintime'] = $result['logintime'];
                $anewinfo = array();
                $anewinfo['logintime'] = time();
                $anewinfo['loginip'] = $_SERVER['REMOTE_ADDR'];
                $adal->UpdateAdmin($ainfo, $anewinfo);
                return true;
            }
        }
        return false;
    }

    public static function AdminLogout()
    {
        unset($_SESSION['admin_userid']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_permission']);
        unset($_SESSION['admin_loginip']);
        unset($_SESSION['admin_logintime']);
    }

    public static function AdminCheck()
    {
        if (isset($_SESSION['admin_userid']) && isset($_SESSION['admin_username']) && $_SESSION['admin_userid'] && $_SESSION['admin_username']) {
            $rnum = rand(0, 9);
            if ($rnum < 4) {
                $adal = new AdminDAL();
                $ainfo['id'] = $_SESSION['admin_userid'];
                $result = $adal->GetAdminOne($ainfo);
                if ($result)
                    if ($result['username'] == $_SESSION['admin_username'])
                        return true;
            } else if ($rnum >= 4) {
                return true;
            }
        }
        return false;
    }
}