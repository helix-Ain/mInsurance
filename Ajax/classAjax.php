<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/4/5
 * Time: 22:34
 */
require_once dirname(__FILE__) . '/../include/global.php';
header('Content-Type:text/plain; charset=UTF-8');
if (!Auth::AdminCheck() && !(Auth::TeacherCheck() && $_REQUEST['action']=='getlist')) {
    $response = array(
        'code' => 2,
        'desc' => '未登录'
    );
    echo json_encode($response);
    exit();
}
$action = $_REQUEST['action'];
if ($action == 'getlist')
    getClassList($_REQUEST);
else if ($action == 'dele')
    deleClass($_REQUEST);
else if ($action == 'add')
    addClass($_REQUEST);
else if ($action == 'modify')
    modifyClass($_REQUEST);
else
    echo 'fuck you bitch';

function getClassList($params)
{
    $classDal = new ClassDAL();
    $schoolDal=new SchoolDAL();
    $majorDal=new MajorDAL();
    unset($params['action']);
    if(isset($params['major'])&&!isset($params['majorid'])){
        $params['majorid'] = $majorDal->GetMajorOne(['name'=>$params['major']])['id'];
    }
    unset($params['major']);
    if(Auth::TeacherCheck()){
        $params['schoolid']=$_SESSION['teacher_schoolid'];
    }
    $classList = $classDal->GetClassList($params);
    if ($classList) {
        foreach($classList as &$class) {
            $class['school']=$schoolDal->GetSchoolOne(array('id'=>$class['schoolid']))['name'];
            $class['major']=$majorDal->GetMajorOne(array('id'=>$class['majorid']))['name'];
        }
        unset($class);
        $response = array(
            'code' => 0,
            'data' => $classList,
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

function deleClass($params)
{
    $classDal = new ClassDal();
	$studentDal = new StudentDAL();
	$scholarshipDal = new ScholarshipDAL();
    if(!is_array($params['classid'])){
        $info['classid'] = explode(',',$params['id']);
    }else{
        $info['classid'] = $params['classid'];
    }
    $flag = true;
    foreach ($info['classid'] as $id) {
        $flag = $flag && $classDal->DeleteClass(['classid' => $id]);
		$students = $studentDal->GetStudentList(['classid'=>$id]);
		foreach($students as $student){
			$flag = $flag && $scholarshipDal->UnsetGainer(['stuid'=>$student['stuid']]);
		}
		$flag = $flag && $studentDal->DeleteStudent(['classid'=>$id]);
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

function addClass($params)
{
    $classDAL = new ClassDAL();
    $info['classid'] = $params['classid'];
    $info['schoolid'] = $params['schoolid'];
    $info['majorid'] = $params['majorid'];
    $result = $classDAL->CreateClass($info);
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

function modifyClass($params)
{
    $classDAL = new ClassDAL();
    $info['classid'] = isset($params['classid']) ? $params['classid'] : NULL;
    $info['schoolid'] = isset($params['schoolid']) ? $params['schoolid'] : NULL;
    $info['majorid'] = isset($params['majorid']) ? $params['majorid'] : NULL;
    $result = $classDAL->UpdateClass(array('classid' => $params['classid']), $info);
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
