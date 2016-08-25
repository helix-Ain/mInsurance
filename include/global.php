<?php
/**
 * Created by PhpStorm.
 * User: kuang
 * Date: 2016/3/25
 * Time: 15:02
 */

require_once(dirname(__FILE__).'/../conf/config.php');
require_once(dirname(__FILE__).'/../libs/Verify.class.php');
require_once(dirname(__FILE__).'/function/Auth.inc.php');
require_once(dirname(__FILE__).'/function/Yibao.inc.php');
require_once(dirname(__FILE__).'/DAL/AdminDAL.inc.php');
require_once(dirname(__FILE__).'/DAL/ClassDAL.inc.php');
require_once(dirname(__FILE__).'/DAL/MajorDAL.inc.php');
require_once(dirname(__FILE__).'/DAL/SchoolDAL.inc.php');
require_once(dirname(__FILE__).'/DAL/StudentDAL.inc.php');
require_once(dirname(__FILE__).'/DAL/TeacherDAL.inc.php');
require_once(dirname(__FILE__).'/DAL/ScholarshipDAL.inc.php');
date_default_timezone_set('Asia/Shanghai');
session_start();