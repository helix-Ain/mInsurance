<?php
require_once dirname(__FILE__).'/../../include/global.php';
$role['teacher']=Auth::TeacherCheck();
$role['admin']=Auth::AdminCheck();
if(!($role['teacher'] || $role['admin'])) {
    header("Location: /index.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="Shortcut Icon" href="/Public/favicon.ico">
    <title>信息登记系统</title>
    <link rel="stylesheet" type="text/css" href="/public/admin/css/common.css" />
    <link rel="stylesheet" type="text/css" href="/public/admin/css/main.css" />
    <link rel="stylesheet" href="/public/bootstrap-3.3.5-dist/css/bootstrap.min.css" />
    <script src="/public/js/jquery-1.11.1.min.js"></script>
    <script src="/public/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/public/admin/js/libs/modernizr.min.js"></script>
    <link rel="stylesheet" href="/public/artDialog/css/ui-dialog.css" />
    <script src="/public/artDialog/dist/dialog-min.js"></script>
    <link rel="stylesheet" href="/public/DataTables-1.10.4/media/css/jquery.dataTables.min.css" />
    <script src="/public/DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>
    <script src="/public/js/ajaxfileupload.js"></script>
    <style>
        * {
            font-family:'Microsoft YaHei';
        }

        h1 {
            font-size: 100%;
            font-weight: normal;
            margin: 0;
            line-height: 40px;
        }

        a:hover {
            text-decoration: none;
        }

        textarea {
            margin: 10px 0 10px 0;
        }

        .common-text {
            margin: 10px 0 10px 0;
            height: 35px;
        }

        .kind-work input {
            margin-bottom: 15px;
            margin-left: 15px;
        }

        .tip {
            color: red;
            font-size: medium;
            display: none;
        }
        #listview{
            display:none;
        }
        label.checkbox-inline{
            margin-bottom:5px;
        }
    </style>
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="/index.php">首页</a></li>
                <li><a href="/index.php">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <?php if($role['admin']){?>
                    <li><a href="javascript:" onclick="administrator()">管理员</a></li>
                <?php }else{ ?>
                    <li><a href="javascript:" onclick="teacher()"><?php echo $_SESSION["teacher_operator"]."老师";?></a></li>
                <?php } ?>
                <li><a href="javascript:" onclick="changePwd()">修改密码</a></li>
                <li><a href="javascript:" id="logout">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container-fluid clearfix" style="padding: 0;">
    <div class="sidebar-wrap" style="position: absolute;height:100%;">
        <div class="sidebar-title">
            <h1>菜单</h1>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <li>
                    <a href="javascript:tab(0);"><i class="icon-font">&#xe003;</i>系统管理</a>
                    <ul class="sub-menu">
                    <?php if($role['admin']){ ?>
                        <li><a href="/views/pages/school.php"><i class="icon-font">&#xe005;</i>学院管理</a></li>
                        <li><a href="/views/pages/teacher.php"><i class="icon-font">&#xe005;</i>教师管理</a></li>
                    <?php } ?>
                        <li><a href="/views/pages/major.php"><i class="icon-font">&#xe005;</i>专业管理</a></li>
                        <li><a href="/views/pages/class.php"><i class="icon-font">&#xe005;</i>班级管理</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:tab(1);"><i class="icon-font">&#xe003;</i>学生管理</a>
                    <ul class="sub-menu">
                        <li><a href="/views/pages/export.php"><i class="icon-font">&#xe010;</i>导出学生</a></li>
                        <li><a href="/views/pages/import.php"><i class="icon-font">&#xe011;</i>导入学生</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:tab(2);"><i class="icon-font">&#xe003;</i>奖学金管理</a>
                    <ul class="sub-menu">
                        <li><a href="/views/pages/gainer.php"><i class="icon-font">&#xe005;</i>获奖人列表</a></li>
                <?php if($role['admin']){ ?>
                        <li><a href="/views/pages/level.php"><i class="icon-font">&#xe006;</i>奖学金列表</a></li>
                        <li><a href="/views/pages/term.php"><i class="icon-font">&#xe049;</i>分学期管理</a></li>
                <?php } ?>
                    </ul>
                </li>
                <li>
                    <a href="javascript:tab(3);"><i class="icon-font">&#xe018;</i>系统管理</a>
                    <ul class="sub-menu">
                        <li><a href="/views/pages/index.php"><i class="icon-font">&#xe017;</i>系统信息</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>