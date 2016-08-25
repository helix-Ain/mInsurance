<?php
include dirname(__FILE__).'/../includes/header.php';
if(!$role['admin']) {
    echo 'Access Denied';
    exit;
}
?>
<div class="modal fade" id="teacher-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="teacher-modal-title" class="modal-title">添加教师</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <div class="form-group">
                            <label for="teacher-username">用户名称:</label>
                            <input type="text" class="form-control" id="teacher-username" />
                        </div>
                        <div class="form-group">
                            <label for="teacher-operator">操作员:</label>
                            <input type="text" class="form-control" id="teacher-operator" />
                        </div>
                        <div class="form-group">
                            <label for="teacher-school">所属学院:</label>
                            <select id="teacher-school" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="teacher-password">登陆密码:</label>
                            <input type="text" class="form-control" id="teacher-password" />
                        </div>
                        <div class="form-group">
                            <label for="teacher-description">教师描述:</label>
                            <input type="text" class="form-control" id="teacher-description" />
                        </div>
                        <button id="teacher-submit" type="button" class="btn btn-default">提交</button>
                        <span id="teacher-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modify-teacher-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="modify-teacher-modal-title" class="modal-title">修改教师信息</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <input type="hidden" id="modify-teacher-id" />
                        <div class="form-group">
                            <label for="modify-teacher-username">用户名称:</label>
                            <input type="text" class="form-control" id="modify-teacher-username" />
                        </div>
                        <div class="form-group">
                            <label for="modify-teacher-operator">操作员:</label>
                            <input type="text" class="form-control" id="modify-teacher-operator" />
                        </div>
                        <div class="form-group">
                            <label for="modify-teacher-school">所属学院:</label>
                            <select id="modify-teacher-school" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="modify-teacher-description">教师描述:</label>
                            <input type="text" class="form-control" id="modify-teacher-description" />
                        </div>
                        <button id="modify-teacher-submit" type="button" class="btn btn-default">保存</button>
                        <span id="modify-teacher-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<button id="btn-modify-teacher-mod" style="display:none;" data-toggle="modal" data-target="#modify-teacher-mod"></button>
<div class="main-wrap">
    <div style="margin-top:1px;">
        <div class="crumb-wrap">
            <div class="crumb-list">
                <i class="icon-font" style="margin-left:-25px;"></i>
                <a href="/index.php">首页</a>
                <span class="crumb-step">&gt;</span>
                <span>教师管理</span>
            </div>
        </div>
        <div class="result-wrap" id="wrap1">
            <div class="result-title" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
                <div class="result-list">
                    <a href="#" id="allRemove">
                        <span class="glyphicon glyphicon-trash"></span>
                        批量删除
                    </a>
                    <a href="#" data-toggle="modal" data-target="#teacher-mod">
                        <span class="glyphicon glyphicon-plus"></span>
                        添加教师
                    </a>
                </div>
            </div>
            <div class="result-content">
                <table id="listview" class="result-tab" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="tc" style="width: 5%;">
                                <input class="allChoose" name="allChoose" id="allChoose" type="checkbox" />
                            </th>
                            <th>用户名</th>
                            <th>操作员</th>
                            <th>学院</th>
                            <th>描述</th>
                            <th>最近登陆时间</th>
                            <th>最近登陆ip</th>
                            <th style="width:12%;">操作</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $.ajax({
            url: '/Ajax/teacherAjax.php',
            type: 'get',
            data:{action:'getlist'},
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        var day = new Date(item.logintime * 1000);
                        $('#listview  tbody').append('<tr id='+item.id+'><td class="tc"><input type="checkbox" name="' + item.id + '"/></td><td>' + item.username + '</td><td>'+item.operator+'</td><td data-tag='+item.schoolid+'>' + item.school + '</td><td>' + item.description + '</td><td>' + day.toLocaleString() + '</td><td>'+item.loginip+'</td><td><a class="btn btn-info btn-xs" onclick="modifyTeacher('+item.id+')">修改</a><a style="margin-left:5px;" class="btn btn-danger btn-xs" onclick="deleTeacher('+item.id+')">删除</a></td></tr>');
                    });
                }
                else {
                    window.console.log(result.code+':'+result.desc);
                }
                $('#listview').dataTable({
                    //初始化时指定某列不排序
                    "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] }],
                    oLanguage: {
                        sUrl: "/public/DataTables-1.10.4/cn.txt"
                    }
                });
                $('#listview').fadeIn();
            }
        });

        $.ajax({
            url: '/Ajax/schoolAjax.php',
            data: { action: 'getlist' },
            type: 'get',
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        $('#teacher-school').append('<option value=' + item.id + '>' + item.name + '</option>');
                        $('#modify-teacher-school').append('<option value='+item.id+'>'+item.name+'</option>');
                    });
                }
                else {
                    window.console.log(result.code+':'+result.desc);
                }
            }
        });
        $('#teacher-submit').on('click', function () {
            if ($('#teacher-username').val() != '' &&$('#teacher-operator').val()!=''&& $('#teacher-school').val() != '' && $('#teacher-password').val() != '') {
                $.ajax({
                    url: '/Ajax/teacherAjax.php',
                    data: { action: 'add', username: $('#teacher-username').val(), operator:$('#teacher-operator').val(),password: $('#teacher-password').val(), schoolid: $('#teacher-school').val(), description: $('#teacher-description').val() },
                    type: 'post',
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            location.reload();
                        }
                        else {
                            window.console.log(result.code+':'+result.desc);
                        }
                    }
                });
            }
            else {
                $('#teacher-tip').html('教师名称或教师所属学院或教师密码不能为空!');
                window.setTimeout(function () {
                    $('#teacher-tip').html('');
                }, 3000);
            }
        });
        $('#allChoose').change(function () {
            if ($('#allChoose').prop('checked') == true) {
                $('input[type="checkbox"]').prop('checked', true);
            }
            else {
                $('input[type="checkbox"]').prop('checked', false);
            }
        });
        $('#allRemove').click(function () {
                var ids = [];
                $.each($('input[type="checkbox"]:checked'), function () {
                    if ($(this).attr('name') == 'allChoose') {
                        return true;
                    }
                       ids.push($(this).attr('name'));
                });
                deleTeacher(ids);
        });
        $('#modify-teacher-submit').click(function () {
            $.ajax({
                url: '/Ajax/teacherAjax.php',
                type: 'post',
                data: { action:'modify',id:$('#modify-teacher-id').val(),username: $('#modify-teacher-username').val(), operator: $('#modify-teacher-operator').val(), schoolid: $('#modify-teacher-school').val(), description: $('#modify-teacher-description').val() },
                dataType: 'json',
                success: function (result) {
                    if (result.code == 0) {
                        location.reload();
                    }
                    else {
                        window.console.log(result.code+':'+result.desc);
                    }
                }
            });
        });
    });
    function modifyTeacher(id) {
        var $tr = $('#' + id);
        $('#modify-teacher-id').val(id);
        $('#modify-teacher-username').val($tr.find('td:eq(1)').html());
        $('#modify-teacher-operator').val($tr.find('td:eq(2)').html());
        $('#modify-teacher-school').val($tr.find('td:eq(3)').data('tag'));
        $('#modify-teacher-description').val($tr.find('td:eq(4)').html());
        $('#btn-modify-teacher-mod').trigger('click');
    }
    function deleTeacher(id) {
            if (!(id instanceof Array)) {
                id = [id];
            }
            if (confirm('确认删除?')) {
                $.ajax({
                    url: '/Ajax/teacherAjax.php',
                    data: { action: 'dele', id: id },
                    type: 'post',
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            location.reload();
                        }
                        else {
                            window.console.log(result.code + ':' + result.desc);
                        }
                    }
                });
            }
    }
</script>

<?php include dirname(__FILE__).'/../includes/footer.php';?>