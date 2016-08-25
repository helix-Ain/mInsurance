<?php

/**
 * Login short summary.
 *
 * Login description.
 *
 * @version 1.0
 * @author Ain
 */
require_once dirname(__FILE__).'/../include/global.php';
$action=$_REQUEST['action'];
if($action=='checkLogin')
    checkLogin($_REQUEST);
else if ($action=='getCode')
    getCode($_REQUEST);
else
    echo 'fuck you bitch';

function checkLogin($params){
    header('Content-Type:text/plain; charset=UTF-8');
    $verify=new Verify();
    $username=$params['username'];
    $password=$params['password'];
    $code=$params['code'];
    $id=$params['id'];
    if($verify->check($code,$id)){
        if(Auth::AdminLogin($username,$password)||Auth::TeacherLogin($username,$password)){
            $response=array(
                'code'=>0,
                'desc'=>'登陆成功'
                );
        }
        else{
            $response=array(
                'code'=>1,
                'desc'=>'用户名或密码错误'
                );
        }
    }
    else{
        $response=array(
            'code'=>2,
            'desc'=>'验证码错误'
            );
    }
    echo json_encode($response);
}

function getCode($params){
    $verify=new Verify();
    $verify->useNoise=false;
    $verify->useImgBg=true;
    $verify->imageW=100;
    $id=$params['id'];
    $verify->entry($id);
}
