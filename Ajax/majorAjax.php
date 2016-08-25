<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/4/5
 * Time: 22:33
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
    getMajorList($_REQUEST);
else if ($action == 'dele')
    deleMajor($_REQUEST);
else if ($action == 'add')
    addMajor($_REQUEST);
else if ($action == 'modify')
    modifyMajor($_REQUEST);
else
    echo 'fuck you bitch';

function getMajorList($params)
{
    $majorDal = new MajorDAL();
    $schoolDal=new SchoolDAL();
    unset($params['action']);
    if(isset($params['school'])&&!isset($params['schoolid'])){
        $params['schoolid']=$schoolDal->GetSchoolOne(['name'=>$params['school']])['id'];
    }
    if(Auth::TeacherCheck()){
        $params['schoolid']=$_SESSION['teacher_schoolid'];
    }
    unset($params['school']);
    $majorList = $majorDal->GetMajorList($params);
    if ($majorList) {
        foreach($majorList as &$major) {
            $major['school']=$schoolDal->GetSchoolOne(array('id'=>$major['schoolid']))['name'];
        }
        unset($major);
        $response = array(
            'code' => 0,
            'data' => $majorList,
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

function deleMajor($params)
{
    $majorDal = new MajorDAL();
	$classDal = new ClassDAL();
	$studentDal = new StudentDAL();
	$scholarshipDal = new ScholarshipDAL();
    if(!is_array($params['id'])){
        $info['id'] = explode(',',$params['id']);
    }else{
        $info['id'] = $params['id'];
    }
    $flag = true;
    foreach ($info['id'] as $id) {
    	$major = $flag && $majorDal->GetMajorOne(['id'=>$id]);
        $flag = $flag && $majorDal->DeleteMajor(['id' => $id]);
		$flag = $flag && $classDal->DeleteClass(['majorid'=>$id]);
		$students = $studentDal->GetStudentList(['major'=>$major]);
		foreach($students as $student){
			$flag = $flag && $scholarshipDal->UnsetGainer(['stuid'=>$student['stuid']]);
		}
		$flag = $flag && $studentDal->DeleteStudent(['major'=>$major]);
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

function addMajor($params)
{
    $majorDAL = new MajorDAL();
    $info['name'] = $params['name'];
    $info['schoolid'] = $params['schoolid'];
    $result = $majorDAL->CreateMajor($info);
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

function modifyMajor($params)
{
    $majorDAL = new MajorDAL();
    $info['name'] = isset($params['name']) ? $params['name'] : NULL;
    $info['schoolid'] = isset($params['schoolid']) ? $params['schoolid'] : NULL;
    $id = $params['id'];
    $result = $majorDAL->UpdateMajor(array('id' => $id), $info);
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