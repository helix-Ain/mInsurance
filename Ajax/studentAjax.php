<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/4/5
 * Time: 22:41
 */

require_once dirname(__FILE__) . '/../include/global.php';
header('Content-Type:text/plain; charset=UTF-8');
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
    getStudentList($_REQUEST);
} else if ($action == 'getone') {
    addStudent($_REQUEST);
} else if ($action == 'add') {
    addStudent($_REQUEST);
} else if ($action == 'dele') {
    deleStudent($_REQUEST);
} else if ($action == 'modify') {
    modifyStudent($_REQUEST);
} else if ($action == 'export') {
    exportStudent($_REQUEST);
} else if ($action == 'import') {
    importStudent($_REQUEST);
} else if ($action == 'preimport') {
    preimportStudent($_REQUEST);
} else {
    echo 'fuck you bitch';
}


function getStudentList($params)
{
    $studentDal = new StudentDAL();
    $info['school'] = isset($params['school']) ? $params['school'] : NULL;
    $info['major'] = isset($params['major']) ? $params['major'] : NULL;
    $info['classid'] = isset($params['classid']) ? $params['classid'] : NULL;
    $result = $studentDal->GetStudentList($info);
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

function getStudentOne($params)
{
    $studentDal = new StudentDAL();
    $result = NULL;
    $info['stuid'] = isset($params['stuid']) ? $params['stuid'] : NULL;
    if ($info['stuid'])
        $result = $studentDal->GetStudentOne($info);
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

function addStudent($params)
{
    $studentDal = new StudentDAL();
    $info['stuid'] = isset($params['stuid']) ? $params['stuid'] : NULL;
    $info['name'] = isset($params['name']) ? $params['name'] : NULL;
    $info['identification'] = isset($params['identification']) ? $params['identification'] : NULL;
    $info['sex'] = isset($params['sex']) ? $params['sex'] : NULL;
    $info['birthday'] = isset($params['birthday']) ? $params['birthday'] : NULL;
    $info['school'] = isset($params['school']) ? $params['school'] : NULL;
    $info['major'] = isset($params['major']) ? $params['major'] : NULL;
    $info['classid'] = isset($params['classid']) ? $params['classid'] : NULL;
    $info['insured'] = isset($params['insured']) ? $params['insured'] : NULL;
    $info['note'] = isset($params['note']) ? $params['note'] : NULL;
    $result = $studentDal->CreateStudent($info);
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


function deleStudent($params)
{
    $studentDal = new StudentDAL();
	$scholarshipDal = new ScholarshipDAL();
    if(!is_array($params['stuid'])){
        $info['stuid'] = explode(',',$params['stuid']);
    }else{
        $info['stuid'] = $params['stuid'];
    }
    $flag = true;
    foreach ($info['stuid'] as $id) {
        $flag = $flag && $studentDal->DeleteStudent(['stuid' => $id]);
		$flag = $flag && $scholarshipDal->UnsetGainer(['stuid'=>$id]);
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


function modifyStudent($params)
{
    $studentDal = new StudentDAL();
    $info['identification'] = isset($params['identification']) ? $params['identification'] : NULL;
    $info['sex'] = isset($params['sex']) ? $params['sex'] : NULL;
    $info['birthday'] = isset($params['birthday']) ? $params['birthday'] : NULL;
    $info['school'] = isset($params['school']) ? $params['school'] : NULL;
    $info['major'] = isset($params['major']) ? $params['major'] : NULL;
    $info['classid'] = isset($params['classid']) ? $params['classid'] : NULL;
    $info['insured'] = isset($params['insured']) ? $params['insured'] : NULL;
    $info['note'] = isset($params['note']) ? $params['note'] : NULL;
    $result = $studentDal->UpdateStudent(array('stuid' => $params['stuid']), $info);
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

function exportStudent($params)
{
    $info['school'] = isset($params['school']) && $params['school'] != '' ? $params['school'] : NULL;
    $info['major'] = isset($params['major']) && $params['major'] != '' ? $params['major'] : NULL;
    $info['classid'] = isset($params['classid']) && $params['classid'] != '' ? $params['classid'] : NULL;
    $info['insured'] = isset($params['insured']) && $params['insured'] != '' ? $params['insured'] : NULL;
	if(!is_array($params['fields'])){
		$fields = explode(',',$params['fields']);
	}else{
		$fields = $params['fields'];
	}
    $result = Yibao::exportExcelByField($info,$fields);
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

function importStudent($params)
{
    $response = array(
        'code' => 2,
        'desc' => '没有提交'
    );
    if (isset($params['data']) && $params['data']) {
        $data = $params['data'];
        if ($data) {
            $result = Yibao::importDb($data);
        }
        if (isset($result) && $result != NULL) {
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
    }
    echo json_encode($response);
}

function preimportStudent($rarams)
{
    if (isset($_FILES['stufile']) && $_FILES['stufile']['name']) {
        $tmp_file = $_FILES['stufile']['tmp_name'];
        $filename = $_FILES['stufile']['name'];
        $filename_arr = explode('.', $filename);
        if ($filename_arr[count($filename_arr) - 1] == 'xls') {
            $data = Yibao::preimport($tmp_file);
            $response = array(
                'code' => 0,
                'succeeddata' => $data['succeeddata'],
                'faileddata' => $data['faileddata'],
                'desc' => '成功解析' . count($data['succeeddata']) . '个学生，失败' . count($data['faileddata']) . '个学生'
            );
        } else {
            $response = array(
                'code' => 101,
                'desc' => '非法文件'
            );
        }
    } else {
        $response = array(
            'code' => 102,
            'desc' => '未提交文件'
        );
    }
    echo json_encode($response);
}