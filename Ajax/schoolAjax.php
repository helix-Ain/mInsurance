<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/4/5
 * Time: 22:28
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
    getSchoolList($_REQUEST);
else if ($action == 'dele')
    deleSchool($_REQUEST);
else if ($action == 'add')
    addSchool($_REQUEST);
else if ($action == 'modify')
    modifySchool($_REQUEST);
else
    echo 'fuck you bitch';

function getSchoolList($params)
{
    $schoolDal = new SchoolDAL();
    if(Auth::TeacherCheck())
        $schoolList = $schoolDal->GetSchoolList(array('id'=>$_SESSION['teacher_schoolid']));
    else
        $schoolList = $schoolDal->GetSchoolList();
    if ($schoolList) {
        $response = array(
            'code' => 0,
            'data' => $schoolList,
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

function deleSchool($params)
{
    $schoolDal = new SchoolDAL();
	$teacherDal = new TeacherDAL();
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
    	$school = $schoolDal->GetSchoolOne(['id'=>$id])['name'];
        $flag = $flag && $schoolDal->DeleteSchool(['id' => $id]);
		$flag = $flag && $teacherDal->DeleteTeacher(['schoolid'=>$id]);
		$flag = $flag && $majorDal->DeleteMajor(['schoolid'=>$id]);
		$flag = $flag && $classDal->DeleteClass(['schoolid'=>$id]);
		$students = $studentDal->GetStudentList(['school'=>$school]);
		foreach($students as $student){
			$flag = $flag && $scholarshipDal->UnsetGainer(['stuid'=>$student['stuid']]);
		}
		$flag = $flag && $studentDal->DeleteStudent(['school'=>$school]);
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

function addSchool($params)
{
    $schoolDAL = new SchoolDAL();
    $info['name'] = isset($params['name']) ? $params['name'] : NULL;
    $info['telephone'] = isset($params['telephone']) ? $params['telephone'] : NULL;
    $info['description'] = isset($params['description']) ? $params['description'] : NULL;
    $result = $schoolDAL->CreateSchool($info);
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

function modifySchool($params)
{
    $schoolDAL = new SchoolDAL();
    $info['name'] = isset($params['name']) ? $params['name'] : NULL;
    $info['telephone'] = isset($params['telephone']) ? $params['telephone'] : NULL;
    $info['description'] = isset($params['description']) ? $params['description'] : NULL;
    $result = $schoolDAL->UpdateSchool(array('id' => $params['id']), $info);
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