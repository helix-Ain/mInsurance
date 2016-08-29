<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/4/5
 * Time: 22:41
 */

require_once dirname(__FILE__) . '/../include/global.php';
//header('Content-Type:text/plain; charset=UTF-8');
if (!Auth::TeacherCheck() && !Auth::AdminCheck()) {
    $response = array(
        'code' => 2,
        'desc' => '未登录'
    );
    echo json_encode($response);
    exit();
}
$action = $_REQUEST['action'];
if ($action == 'getlist') {
    getScholarshipGainerList($_REQUEST);
} else if ($action == 'set') {
    setScholarshipGainer($_REQUEST);
} else if ($action == 'dele') {
    deleScholarshipGainer($_REQUEST);
} else if ($action == 'modify') {
    modifyScholarshipGainer($_REQUEST);
} else if ($action == 'export') {
    exportScholarshipGainer($_REQUEST);
} else {
    echo 'fuck you bitch';
}


function getScholarshipGainerList($params)
{
    $scholarshipDal = new ScholarshipDAL();
    $schoolDal = new SchoolDAL();
    $info['school'] = isset($params['school']) ? $params['school'] : NULL;
    $info['major'] = isset($params['major']) ? $params['major'] : NULL;
    $info['classid'] = isset($params['classid']) ? $params['classid'] : NULL;
    $info['termid'] = isset($params['termid']) ? $params['termid'] : NULL;
    $info['levelid'] = isset($params['levelid']) ? $params['levelid'] : NULL;
    if(Auth::TeacherCheck()){
        $params['schoolid']=$_SESSION['teacher_schoolid'];
        $info['school'] = $schoolDal->GetSchoolOne(['id'=>$params['schoolid']])['name'];
    }
    $result = $scholarshipDal->GetScholarshipList($info);
    if ($result) {
        foreach($result as &$item){
            $item['term'] = $scholarshipDal->GetTermOne(['id'=>$item['termid']])['title'];
        }
        $response = array(
            'code' => 0,
            'data' => $result,
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


function setScholarshipGainer($params)
{
    $studentDal = new StudentDAL();
    $scholarshipDal = new ScholarshipDAL();
    $result = false;
    $info['stuid'] = isset($params['stuid']) ? $params['stuid'] : NULL;
    $info['levelid'] = isset($params['levelid']) ? $params['levelid'] : NULL;
    $info['termid'] = isset($params['termid']) ? $params['termid'] : NULL;
    $student = $studentDal->GetStudentOne(array('stuid' => $info['stuid'], 'name' => NULL, 'identification' => NULL));
    if ($student){
        $result = $scholarshipDal->SetGainer($info);
    }
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


function deleScholarshipGainer($params)
{
    $scholarshipDal = new ScholarshipDAL();
    if(!is_array($params['stuid'])){
        $info['stuid'] = explode(',',$params['stuid']);
    }else{
        $info['stuid'] = explode(',',$params['stuid']);
    }
    $flag = true;
    foreach ($info['stuid'] as $id) {
        $flag = $flag && $scholarshipDal->UnsetGainer(['stuid' => $id]);
    }
    if ($flag) {
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

function modifyScholarshipGainer($params)
{
    $scholarshipDal = new ScholarshipDAL();
    $info['stuid'] = isset($params['stuid']) ? $params['stuid'] : NULL;
    $info['levelid'] = isset($params['levelid'])?$params['levelid']:NULL;
    $info['termid'] = isset($params['termid'])?$params['termid']:NULL;
    $result = $scholarshipDal->UpdateGainerById($info,$params['id']);
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

function exportScholarshipGainer($params)
{
    $info['school'] = isset($params['school']) && $params['school'] != '' ? $params['school'] : NULL;
    $info['major'] = isset($params['major']) && $params['major'] != ''&&$params['major']!='null' ? $params['major'] : NULL;
    $info['classid'] = isset($params['classid']) && $params['classid'] != ''&&$params['classid']!='null' ? $params['classid'] : NULL;
    $info['levelid'] = isset($params['levelid'])&&$params['levelid']!=''?$params['levelid']:NULL;
    $info['termid'] = isset($params['termid'])&&$params['termid']!=''?$params['termid']:NULL;
    if($info['school']!=NULL){
        $schoolDal = new SchoolDAL();
        $info['school'] = $schoolDal->GetSchoolOne(['id'=>$info['school']])['name'];
        if($info['major']!=NULL){
            $majorDal = new MajorDAL();
            $info['major'] = $majorDal->GetMajorOne(['id'=>$info['major']])['name'];
        }
    }
    if(!is_array($params['fields'])){
		$fields = explode(',',$params['fields']);
	}else{
		$fields = $params['fields'];
	}
    $result = Yibao::exportExcelByField($info,$fields,true);
    if ($result) {
        $response = array(
            'code' => 0,
            'url' => $result,
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

