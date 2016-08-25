<?php
header('Content-Type:text/html; charset=UTF-8');
require_once __DIR__.'/include/global.php';
require_once __DIR__.'/vendor/autoload.php';
/**
 * 入口文件
 *
 * index description.
 *
 * @version 1.0
 * @author Ain
 */
define('ROOT',__DIR__);
define('DEBUG',true);

error_reporting(0);

if(DEBUG){
    error_reporting(E_ALL);
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

if(Auth::TeacherCheck() || Auth::AdminCheck()) {
    if (Auth::TeacherCheck()) {
        include dirname(__FILE__) . '/views/pages/index.php';
    } else if (Auth::AdminCheck()) {
        include dirname(__FILE__) . '/views/pages/index.php';
    }
}
else{
    include dirname(__FILE__).'/views/pages/login.php';
}
?>