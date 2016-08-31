<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/4/5
 * Time: 22:28
 */
require_once dirname(__FILE__) . '/../include/global.php';
//header('Content-Type:text/plain; charset=UTF-8');
if (!Auth::AdminCheck() && !(Auth::TeacherCheck() && $_REQUEST['action'] == 'getlist')) {
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
    getScholarshipLevelList($_REQUEST);
else if ($action == 'dele')
    deleScholarshipLevel($_REQUEST);
else if ($action == 'add')
    addScholarshipLevel($_REQUEST);
else if ($action == 'modify')
    modifyScholarshipLevel($_REQUEST);
else
    echo 'fuck you bitch';

function getScholarshipLevelList($params)
{
    $scholarshipDal = new ScholarshipDAL();
    $slList = $scholarshipDal->GetLevelList();
    if ($slList) {
        $response = array(
            'code' => 0,
            'data' => $slList,
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

function deleScholarshipLevel($params)
{
    $scholarshipDal = new ScholarshipDAL();
	if(!is_array($params['id'])){
		$info['id'] = explode(',', $params['id']);
	}else{
		$info['id'] = $params['id'];
	}
    $flag = true;
    foreach ($info['id'] as $id) {
        $flag = $flag && $scholarshipDal->DeleteLevel(['id' => $id]);
		$scholarshipDal->UnsetGainer(['levelid'=>$id]);
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

function addScholarshipLevel($params)
{
    $scholarshipDal = new ScholarshipDAL();
    $info['levelname'] = isset($params['levelname']) ? $params['levelname'] : NULL;
    $info['money'] = isset($params['money']) ? $params['money'] : NULL;
    $info['note'] = isset($params['note']) ? $params['note'] : NULL;
    $result = $scholarshipDal->CreateLevel($info);
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

function modifyScholarshipLevel($params)
{
    $scholarshipDal = new ScholarshipDAL();
    $info['levelname'] = isset($params['levelname']) ? $params['levelname'] : NULL;
    $info['money'] = isset($params['money']) ? $params['money'] : NULL;
    $info['note'] = isset($params['note']) ? $params['note'] : NULL;
    $result = $scholarshipDal->UpdateLevel(array('id' => $params['id']), $info);
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