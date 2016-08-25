<?php
include dirname(__FILE__).'/../includes/header.php';
if(!($role['admin'] || $role['teacher'])) {
    echo 'Access Denied';
    exit;
}
    ?>
<div class="main-wrap">
    <div style="margin-top:1px;">
        <div class="crumb-wrap">
            <div class="crumb-list" style="position: relative; left: -25px;">
                <i class="icon-font">&#xe06b;</i>
                <span>欢迎使用</span>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>快捷操作</h1>
            </div>
            <div class="result-content">
                <div class="short-wrap">
                    <a href="/views/pages/import.php">
                        <i class="icon-font">&#xe001;</i>
                        导入学生
                    </a>
                    <a href="/views/pages/export.php">
                        <i class="icon-font">&#xe005;</i>
                        导出学生
                    </a>
                </div>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>系统基本信息</h1>
            </div>
            <div class="result-content">
                <ul class="sys-info-list">
                    <li>
                        <label class="res-lab">操作系统</label>
                        <span class="res-info"><?php echo php_uname('s');?></span>
                    </li>
                    <li>
                        <label class="res-lab">运行环境</label>
                        <span class="res-info"><?php echo 'PHP '.PHP_VERSION;?></span>
                    </li>
                    <li>
                        <label class="res-lab">PHP运行方式</label>
                        <span class="res-info"><?php echo php_sapi_name();?></span>
                    </li>
                    <li>
                        <label class="res-lab">版本</label>
                        <span class="res-info">v-0.1</span>
                    </li>
                    <li>
                        <label class="res-lab">上传附件限制</label>
                        <span class="res-info"><?php echo ini_get('upload_max_filesize');?></span>
                    </li>
                    <li>
                        <label class="res-lab">北京时间</label>
                        <span class="res-info"><?php echo date('Y年m月d日 H:i:s');?></span>
                    </li>
                    <li>
                        <label class="res-lab">服务器域名/IP</label>
                        <span class="res-info"><?php echo $_SERVER['SERVER_NAME'].'/'.GetHostByName($_SERVER['SERVER_NAME']);?></span>
                    </li>
                    <li>
                        <label class="res-lab">Host</label>
                        <span class="res-info"><?php echo $_SERVER["REMOTE_ADDR"];?></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>使用帮助</h1>
            </div>
            <div class="result-content">
                <ul class="sys-info-list">
                    <li>
                        <label class="res-lab">电话</label>
                        <span class="res-info">
                            <a class="qq-link">18814182372&nbsp;&nbsp;&nbsp;&nbsp;18814182439</a>
                        </span>
                    </li>
                    <li>
                        <label class="res-lab">邮箱</label>
                        <span class="res-info">
                            <a class="qq-link">1124485179@qq.com&nbsp;&nbsp;&nbsp;&nbsp;kuangjy@qq.com</a>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
include dirname(__FILE__).'/../includes/footer.php';
?>