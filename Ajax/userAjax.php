<?php
/**
 * userMode short summary.
 *
 * userMode description.
 *
 * @version 1.0
 * @author Ain
 */
require_once dirname(__FILE__) . '/../include/global.php';
header('Content-Type:text/plain; charset=UTF-8');
if (!Auth::AdminCheck()&&!Auth::TeacherCheck()) {
    $response = array(
        'code' => 2,
        'desc' => '未登录'
    );
    echo json_encode($response);
    exit();
}
$action=$_REQUEST['action'];
unset($_REQUEST['action']);
if($action=='logout')
    logout($_REQUEST);
else if ($action=='getLoginInfo')
    getLoginInfo($_REQUEST);
else if ($action=='modifyPassword')
    modifyPassword($_REQUEST);
else
    echo 'fuck you bitch';

function logout($params){
    if (Auth::AdminCheck()||Auth::TeacherCheck()) {
        Auth::AdminLogout();
        Auth::TeacherLogout();
        $response = array(
            'code' => 0,
            'desc' => '注销成功'
        );
    }
    else {
        $response = array(
            'code' => 1,
            'desc' => '发生错误'
        );
    }
    echo json_encode($response);
}

function getLoginInfo($params){
    if (Auth::AdminCheck()) {
        $adminDal=new AdminDAL();
        $teacherDal = new TeacherDAL();
        $data = array_merge($adminDal->GetAdminList(),$teacherDal->GetTeacherList());
        $response = array(
            'code' => 0,
            'data' => $data,
            'desc' => '操作成功'
        );
    } else if (Auth::TeacherCheck()) {
        $teacherDal=new TeacherDAL();
        $data=$teacherDal->GetTeacherOne(['id'=>$_SESSION['teacher_userid']]);
        $response = array(
            'code' => 0,
            'data' => $data,
            'desc' => '操作成功'
        );
    } else {
        $response = array(
            'code' => 1,
            'desc' => '操作失败'
        );
    }
    echo json_encode($response);
}

function modifyPassword($params){
    $result = false;
    $oldPwd = $_REQUEST['oldPwd'];
    $newPwd = $_REQUEST['newPwd'];
    if (Auth::AdminCheck()) {
        $adminDal = new AdminDAL();
        $admin = $adminDal->GetAdminOne(['id' => $_SESSION['admin_userid'], 'username' => $_SESSION['admin_username']]);
        if (md5(md5($oldPwd) . $admin['salt']) == $admin['password']) {
            $newPwd = md5(md5($newPwd) . $admin['salt']);
            $result = $adminDal->UpdateAdmin(['id' => $_SESSION['admin_userid'], 'username' => $_SESSION['admin_username']], ['password' => $newPwd]);
        }
    } else if (Auth::TeacherCheck()) {
        $teacherDal = new TeacherDAL();
        $teacher = $teacherDal->GetTeacherOne(['id' => $_SESSION['teacher_userid'], 'username' => $_SESSION['teacher_username']]);
        if (md5(md5($oldPwd) . $teacher['salt']) == $teacher['password']) {
            $newPwd = md5(md5($newPwd) . $teacher['salt']);
            $result = $teacherDal->UpdateTeacher(['id' => $_SESSION['teacher_userid'], 'username' => $_SESSION['teacher_username']], ['password' => $newPwd]);
        }
    } else {
        $response = array(
            'code' => 1,
            'desc' => '操作失败'
        );
    }
    if ($result) {
        $response = array(
            'code' => 0,
            'desc' => '操作成功'
        );
        Auth::AdminLogout();
        Auth::TeacherLogout();
    } else {
        $response = array(
            'code' => 1,
            'desc' => '操作失败'
        );
    }
    echo json_encode($response);
}

?>