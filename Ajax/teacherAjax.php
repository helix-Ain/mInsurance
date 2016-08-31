<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/4/5
 * Time: 22:24
 */
require_once dirname(__FILE__) . '/../include/global.php';
header('Content-Type:text/plain; charset=UTF-8');
if (!Auth::AdminCheck()) {
    $response = array(
        'code' => 2,
        'desc' => '未登录'
    );
    echo json_encode($response);
    exit();
}
$action = $_REQUEST['action'];
unset($_REQUEST['action']);
if ($action == 'getlist')
    getTeacherList($_REQUEST);
else if ($action == 'dele')
    deleTeacher($_REQUEST);
else if ($action == 'add')
    addTeacher($_REQUEST);
else if ($action == 'modify')
    modifyTeacher($_REQUEST);
else
    echo 'fuck you bitch';
function getTeacherList($params)
{
    $teacherDal = new TeacherDAL();
    $schoolDal = new SchoolDAL();
    $teacherList = $teacherDal->GetTeacherList();
    if ($teacherList) {
        foreach ($teacherList as &$teacher) {
            unset($teacher['password']);
            unset($teacher['salt']);
            unset($teacher[2]);
            unset($teacher[3]);
            $teacher['school'] = $schoolDal->GetSchoolOne(array('id' => $teacher['schoolid']))['name'];
        }
        unset($teacher);
        $response = array(
            'code' => 0,
            'data' => $teacherList,
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
function deleTeacher($params)
{
    $teacherDal = new TeacherDAL();
    if(!is_array($params['id'])){
        $info['id'] = explode(',',$params['id']);
    }else{
        $info['id'] = $params['id'];
    }
    $flag = true;
    foreach ($info['id'] as $id) {
        $flag = $flag && $teacherDal->DeleteTeacher(['id' => $id]);
    }
    if ($flag)
        $response = array(
            'code' => 0,
            'desc' => '操作成功'
        );
    else
        $response = array(
            'code' => 1,
            'desc' => '操作失败'
        );
    echo json_encode($response);
}
function addTeacher($params)
{
    $teacherDal = new TeacherDAL();
    $info['username'] = $params['username'];
    $info['operator'] = $params['operator'];
    $info['salt'] = rand();
    $info['password'] = md5(md5($params['password']) . $info['salt']);
    $info['description'] = $params['description'];
    $info['schoolid'] = $params['schoolid'];
    $result = $teacherDal->CreateTeacher($info);
    if ($result) {
        $response = array(
            'code' => 0,
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
function modifyTeacher($params)
{
    $teacherDal = new teacherDAL();
    $info['username'] = $params['username'];
    if (isset($params['password'])) {
        $info['salt'] = rand();
        $info['password'] = md5(md5($params['password']) . $info['salt']);
    }
    $info['description'] = isset($params['description'])?$params['description']:NULL;
    $info['schoolid'] = isset($params['schoolid'])?$params['schoolid']:NULL;
    $result = $teacherDal->UpdateTeacher(array('id' => $params['id']), $info);
    if ($result)
        $response = array(
            'code' => 0,
            'desc' => '操作成功'
        );
    else
        $response = array(
            'code' => 1,
            'desc' => '操作失败'
        );
    echo json_encode($response);
}