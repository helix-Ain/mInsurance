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
            <div class="crumb-list"><i class="icon-font" style="margin-left:-25px;"></i><a href="/index.php">首页</a><span class="crumb-step">&gt;</span><span>导入学生</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-title" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
                <div class="result-list">
                    <a href="javascript:void(0)" id="btn-shoudong">
                        <span class="glyphicon glyphicon-plus"></span>
                        手动导入
                    </a>
                    <a href="javascript:void(0)" id="btn-biaoge">
                        <span class="glyphicon glyphicon-file"></span>
                        表格导入
                    </a>
                    <a href="../../public/template.xls">
                        <span class="glyphicon glyphicon-download"></span>
                        导入表格模板下载
                    </a>
                </div>
            </div>
            <div class="result-content" id="div-shoudong">
                <form action="" method="post" id="myform" name="myform" enctype="multipart/form-data">
                    <table class="insert-tab" style="width: 100%;">
                        <tbody>
                            <tr>
                                <th style="width: 120px;"><i class="require-red">*</i>学院:</th>
                                <td>
                                    <select id="school" class="form-control" style="width:350px;">
                                        <option value="">请选择</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>专业:</th>
                                <td>
                                    <select id="major" class="form-control" style="width:350px;"></select>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>班别:</th>
                                <td>
                                    <select id="classid" class="form-control" style="width:350px;"></select>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>学号:</th>
                                <td>
                                    <input id="stuid" class="common-text bitian" style="width:350px;" type="text">
                                    <span id="tip-stuid" class="tip">&nbsp;&nbsp;学号格式错误!</span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>姓名:</th>
                                <td>
                                    <input id="name" class="common-text bitian" style="width:350px;" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>身份证号码:</th>
                                <td>
                                    <input id="identification" class="common-text bitian" style="width:350px;" />
                                    <span id="tip-identification" class="tip">&nbsp;&nbsp;身份证号格式错误!</span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>性别:</th>
                                <td>
                                    &nbsp;&nbsp;&nbsp;&nbsp;<input name="sex" type="radio" value="男" checked />&nbsp;<span style="line-height: 10px; position: relative; top: 2px;">男</span>&nbsp;&nbsp;&nbsp;&nbsp;<input name="sex" type="radio" value="女" />&nbsp;<span style="line-height: 10px; position: relative; top: 2px;">女</span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>出生年月:</th>
                                <td>
                                    <input type="date" id="birthday" class="common-text bitian" size="50" />
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>是否参保:</th>
                                <td>
                                    <select id="insured" class="form-control" style="width:161px;">
                                        <option value="0">不参保</option>
                                        <option value="1">已参保</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>备注:</th>
                                <td>
                                    <textarea id="note" class="common-textarea form-control" rows="3" style="resize:none;width:75%;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input id="submit" class="btn btn-primary btn6 mr10" value="提交" type="button" />
                                    <span id="tip-all" class="tip">&nbsp;&nbsp;请填写相关必填项!</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="result-content" id="div-biaoge" style="display:none;">
                <div>
                    <input type="file" id="stufile" name="stufile">
                    <button class="btn btn-default btn-sm" style="margin-top:5px;" onclick="ajaxFileUpload()">导入文件</button>
                </div>
                <div id="wait_loading" style="margin-top:15px;margin-left:7px;display:none;">
                    <div><img src="/public/img/loading.gif" style="width:50px;height:50px;" /></div>
                    <br />
                    <div><span>请稍等...</span></div>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#submit').click(function () {
            if ($('#stuid').val() != '' && $('#name').val() != '' && $('#identification').val() != '' && $('#birthday').val() != '' && $('#classid').val() != '' && $('#major').val() != '' && $('#school').val() != '') {
                if (!/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/.test($('#identification').val())) {
                    $('#tip-identification').show();
                    window.setTimeout(function () {
                        $('#tip-identification').hide();
                    }, 3000);
                }
                else {
                    $.ajax({
                        url: '/Ajax/studentAjax.php',
                        type: 'post',
                        data: { action: 'add', stuid: $('#stuid').val(), name: $('#name').val(), identification: $('#identification').val(), sex: $('input[type="radio"][name="sex"]:checked').val(), birthday: $('#birthday').val(), insured: $('#insured').val(), note: $('#note').val(), classid: $('#classid').val(), major: $('#major option:selected').html(), school: $('#school option:selected').html() },
                        dataType: 'json',
                        success: function (result) {
                            if (result.code == 0) {
                                alert('导入成功');
                                $('input').val('');
                            }
                            else {
                                window.console.log(result.code + ':' + result.desc);
                            }
                        }
                    });
                }
            }
            else {
                $('#tip-all').show();
                window.setTimeout(function () {
                    $('#tip-all').hide();
                }, 3000);
            }
        });

        $('#btn-shoudong').click(function () {
            $('#div-biaoge').fadeOut(function () {
                $('#div-shoudong').fadeIn();
            });
        });
        $('#btn-biaoge').click(function () {
            $('#div-shoudong').fadeOut(function () {
                $('#div-biaoge').fadeIn();
            });
        });

        $.ajax({
            url: '/Ajax/schoolAjax.php',
            type: 'post',
            data: { action: 'getlist' },
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        $('#school').append('<option value=' + item.id + '>' + item.name + '</option>');
                    });
                }
                else {
                    window.console.log(result.code + ':' + result.desc);
                }
            }
        });

        $('#school').change(function () {
            $('#major').empty().val('');
            $('#classid').empty().val('');
            if ($('#school').val() != '') {
                $.ajax({
                    url: '/Ajax/majorAjax.php',
                    type: 'get',
                    data: { action: 'getlist', schoolid: $(this).val() },
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            $('#major').append('<option value="">请选择</option>');
                            $.each(result.data, function (i, item) {
                                $('#major').append('<option value=' + item.id + '>' + item.name + '</option>');
                            })
                        }
                        else {
                            window.console.log(result.code + ':' + result.desc);
                        }
                    }
                });
            }
        });

        $('#major').change(function () {
            $('#classid').empty().val('');
            if ($('#major').val() != '') {
                $.ajax({
                    url: '/Ajax/classAjax.php',
                    type: 'get',
                    data: { action: 'getlist', majorid: $(this).val(), schoolid: $('#school').val() },
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            $('#classid').append('<option value="">请选择</option>');
                            $.each(result.data, function (i, item) {
                                $('#classid').append('<option value=' + item.classid + '>' + item.classid + '</option>');
                            });
                        }
                        else {
                            window.console.log(result.code + ':' + result.desc);
                        }
                    }
                });
            }
        });
    });
    var succeedNum, failedNum;
    function ajaxFileUpload() {
        if ($('#stufile').val() == '') {
            return;
        }
        $("#wait_loading").fadeIn();
        $.ajaxFileUpload({
            url: '/Ajax/studentAjax.php?action=preimport',
            type: 'post',
            secureuri: false,
            fileElementId: 'stufile', 
            dataType: 'json', 
            success: function (result, status) {
                succeedNum = result.succeeddata.length;
                failedNum = result.faileddata.length;
                if (result.code == 0 && succeedNum != 0) {
                    $.ajax({
                        url: '/Ajax/studentAjax.php',
                        type: 'post',
                        data: { action: 'import', data: result.succeeddata },
                        dataType: 'json',
                        success: function (result) {
                            if (result.code == 0) {
                                $('#wait_loading').fadeOut();
                                if (confirm('成功解析' + succeedNum + '个学生,失败' + failedNum + '个学生\n' + '成功导入' + result.data['succeedcount'] + '个学生,失败' + result.data['failedcount'] + '个学生,有重复学生' + result.data['existedcount'] + '个')) {
                                    location.href = '/views/pages/export.php';
                                }
                            }
                            else {
                                $('#wait_loading').fadeOut();
                                alert(result.desc);
                                window.console.log(result.code + ':' + result.desc);
                            }
                        }
                    });
                }
                else {
                    $('#wait_loading').fadeOut();
                    alert('成功解析0个学生,失败' + failedNum + '个学生');
                }
            },
            error: function (data, status, e) {
                $('#wait_loading').fadeOut();
                window.console.log(data);
            }
        });
    }
</script>
<?php include dirname(__FILE__).'/../includes/footer.php';?>