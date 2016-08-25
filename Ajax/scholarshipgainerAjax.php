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
    getScholarshipGainerList($params)List($_REQUEST);
} else if ($action == 'set') {
    setScholarshipGainer($params)($_REQUEST);
} else if ($action == 'dele') {
    deleScholarshipGainer($params)($_REQUEST);
} else if ($action == 'modify') {
    modifyStudentGainer($_REQUEST);
} else if ($action == 'export') {
    exportStudentGainer($_REQUEST);
} else {
    echo 'fuck you bitch';
}


function getScholarshipGainerList($params)
{
    $scholarshipDal = new ScholarshipDAL();
    $info['school'] = isset($params['school']) ? $params['school'] : NULL;
    $info['major'] = isset($params['major']) ? $params['major'] : NULL;
    $info['classid'] = isset($params['classid']) ? $params['classid'] : NULL;
    $info['termid'] = isset($params['termid']) ? $params['termid'] : NULL;
    $info['levelid'] = isset($params['levelid']) ? $params['levelid'] : NULL;
    $result = $scholarshipDal->GetScholarshipList($info);
    if ($result) {
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
    $result = NULL;
    $info['stuid'] = isset($params['stuid']) ? $params['stuid'] : NULL;
    $info['levelid'] = isset($params['levelid']) ? $params['levelid'] : NULL;
    $info['termid'] = isset($params['termid']) ? $params['termid'] : NULL;

    $student = $studentDal->GetStudentOne(array('stuid' => $info['stuid'], 'name' => NULL, 'identification' => NULL));
    if ($student)
        $result = $scholarshipDal->SetGainer($info);

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
    foreach ($info['id'] as $id) {
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
    $studentDal = new StudentDAL();
    $info['stuid'] = isset($params['stuid']) ? $params['stuid'] : NULL;
    $info['identification'] = isset($params['identification']) ? $params['identification'] : NULL;
    $info['sex'] = isset($params['sex']) ? $params['sex'] : NULL;
    $info['birthday'] = isset($params['birthday']) ? $params['birthday'] : NULL;
    $info['school'] = isset($params['school']) ? $params['school'] : NULL;
    $info['major'] = isset($params['major']) ? $params['major'] : NULL;
    $info['classid'] = isset($params['classid']) ? $params['classid'] : NULL;
    $info['insured'] = isset($params['insured']) ? $params['insured'] : NULL;
    $info['note'] = isset($params['note']) ? $params['note'] : NULL;
    $result = $studentDal->UpdateStudent(array('stuid' => $params['id']), $info);
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
    $info['major'] = isset($params['major']) && $params['major'] != '' ? $params['major'] : NULL;
    $info['classid'] = isset($params['classid']) && $params['classid'] != '' ? $params['classid'] : NULL;
    $info['levelname'] = isset($params['levelname']) && $params['levelname']!=''?$params['levelname']:NULL;
    $info['levelid'] = isset($params['levelid'])&&$params['levelid']!=''?$params['levelid']:NULL;
    $info['termid'] = isset($params['termid'])&&$params['termid']!=''?$params['termid']:NULL;
    $info['insured'] = isset($params['insured']) && $params['insured'] != '' ? $params['insured'] : NULL;
    $result = Yibao::exportExcel($info);
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

