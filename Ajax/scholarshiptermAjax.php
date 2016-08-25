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
if ($action == 'getlist')
    getScholarshipTermList($_REQUEST);
else if ($action == 'dele')
    deleScholarshipTerm($_REQUEST);
else if ($action == 'add')
    addScholarshipTerm($_REQUEST);
else if ($action == 'modify')
    modifyScholarshipTerm($_REQUEST);
else
    echo 'fuck you bitch';

function getScholarshipTermList($params)
{
    $scholarshipDal = new ScholarshipDAL();
    if (Auth::TeacherCheck())
        $stList = $scholarshipDal->GetTermList(array('currenttime' => date('Y-m-d h:i:s'), 'enabled' => 1));
    else
        $stList = $scholarshipDal->GetTermList();
    if ($stList) {
        $response = array(
            'code' => 0,
            'data' => $stList,
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

function deleScholarshipTerm($params)
{
    $scholarshipDal = new ScholarshipDAL();
	if(!is_array($params['id'])){
		$info['id'] = explode(',',$params['id']);
	}else{
		$info['id'] = $params['id'];
	}
    $flag = true;
    foreach ($info['id'] as $id) {
        $flag = $flag && $scholarshipDal->DeleteTerm(['id' => $id]);
		$flag = $flag && $scholarshipDal->UnsetGainer(['termid'=>$id]);
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

function addScholarshipTerm($params)
{
    $scholarshipDal = new ScholarshipDAL();
    $info['title'] = isset($params['title']) ? $params['title'] : NULL;
    $info['starttime'] = isset($params['starttime']) ? date('Y-m-d h:i:s',intval($params['starttime'])) : date('Y-m-d h:i:s', time());
    $info['endtime'] = isset($params['endtime']) ? date('Y-m-d h:i:s',intval($params['endtime'])) : date('Y-m-d h:i:s', time() + 172800);
    $info['enabled'] = isset($params['enabled']) ? $params['enabled'] : NULL;
    $result = $scholarshipDal->CreateTerm($info);
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

function modifyScholarshipTerm($params)
{
    $scholarshipDal = new ScholarshipDAL();
    $info['title'] = isset($params['title']) ? $params['title'] : NULL;
    $info['starttime'] = isset($params['starttime']) ? date('Y-m-d h:i:s', $params['starttime']) : NULL;
    $info['endtime'] = isset($params['endtime']) ? date('Y-m-d h:i:s', $params['endtime']) : NULL;
    $info['enabled'] = isset($params['enabled']) ? $params['enabled'] : NULL;
    $result = $scholarshipDal->UpdateTerm(array('id' => $params['id']),$info);
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
