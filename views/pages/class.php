<?php
include dirname(__FILE__).'/../includes/header.php';
if(!($role['admin'] || $role['teacher'])) {
    echo 'Access Denied';
    exit;
}
?>
<div class="modal fade" id="class-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="class-modal-title" class="modal-title">添加班级</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <div class="form-group">
                            <label for="class-name">班级名称:</label>
                            <input type="text" class="form-control" id="class-name" />
                        </div>
                        <div class="form-group">
                            <label for="class-school">所属学院:</label>
                            <select id="class-school" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="class-major">所属专业:</label>
                            <select id="class-major" class="form-control"></select>
                        </div>
                        <button id="class-submit" type="button" class="btn btn-default">提交</button>
                        <span id="class-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modify-class-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="class-modal-title" class="modal-title">修改班级</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <input type="hidden" id="modify-class-oldname" />
                        <div class="form-group">
                            <label for="modify-class-name">班级名称:</label>
                            <input type="text" class="form-control" id="modify-class-name" />
                        </div>
                        <div class="form-group">
                            <label for="modify-class-school">所属学院:</label>
                            <select id="modify-class-school" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="modify-class-major">所属专业:</label>
                            <select id="modify-class-major" class="form-control"></select>
                        </div>
                        <button id="modify-class-submit" type="button" class="btn btn-default">保存</button>
                        <span id="class-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<button style="display:none;" id="btn-modify-class-mod" data-toggle="modal" data-target="#modify-class-mod"></button>
<div class="main-wrap">
    <div style="margin-top:1px;">
        <div class="crumb-wrap">
            <div class="crumb-list">
                <i class="icon-font" style="margin-left:-25px;"></i>
                <a href="/index.php">首页</a>
                <span class="crumb-step">&gt;</span>
                <span>班级管理</span>
            </div>
        </div>
        <div class="result-wrap" id="wrap1">
            <div class="result-title" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
                <div class="result-list">
                    <a href="#" id="allRemove">
                        <span class="glyphicon glyphicon-trash"></span>
                        批量删除
                    </a>
                    <a href="#" data-toggle="modal" data-target="#class-mod">
                        <span class="glyphicon glyphicon-plus"></span>
                        添加班级
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
                            <th>班级名称</th>
                            <th>所属专业</th>
                            <th>所属学院</th>
                            <th>操作</th>
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
            url: '/Ajax/classAjax.php',
            data:{action:'getlist'},
            type: 'get',
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        $('#listview  tbody').append('<tr id='+item.classid+'><td class="tc"><input type="checkbox" name="'+item.classid+'"/></td><td>'+item.classid+'</td><td data-tag='+item.majorid+'>'+item.major+'</td><td data-tag='+item.schoolid+'>'+item.school+'</td><td><a class="btn btn-info btn-sm" onclick="modifyClass('+item.classid+')">修改</a><a style="margin-left:5px;" class="btn btn-danger btn-sm" onclick="deleClass('+item.classid+')">删除</a></td></tr>');
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
        $('#allChoose').change(function () {
            if ($('#allChoose').prop('checked') == true) {
                $('input[type="checkbox"]').prop('checked', true);
            }
            else {
                $('input[type="checkbox"]').prop('checked', false);
            }
        });
        $.ajax({
            url: '/Ajax/schoolAjax.php',
            data: { action: 'getlist' },
            type: 'get',
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $('#class-school,#modify-class-school').append('<option value="">请选择</option>');
                    $.each(result.data, function (i, item) {
                        $('#class-school,#modify-class-school').append('<option value='+item.id+'>'+item.name+'</option>');
                    });
                }
                else {
                    window.console.log(result.code+':'+result.desc);
                }
            }
        });
        $('#class-school,#modify-class-school').change(function () {
            if ($(this).attr('id') == 'class-school') {
                action = 'add';
            }
            else {
                action = 'modify';
            }
            if ($(this).val() != '') {
                $.ajax({
                    url: '/Ajax/majorAjax.php',
                    data: { action: 'getlist', schoolid: $(this).val() },
                    type: 'get',
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            if (action == 'add') {
                                $('#class-major').empty();
                                $('#class-major').append('<option value="">请选择</option>');
                                $.each(result.data, function (i, item) {
                                    $('#class-major').append('<option value=' + item.id + '>' + item.name + '</option>');
                                })
                            }
                            else if (action == 'modify') {
                                $('#modify-class-major').empty();
                                $('#modify-class-major').append('<option value="">请选择</option>');
                                $.each(result.data, function (i, item) {
                                    $('#modify-class-major').append('<option value=' + item.id + '>' + item.name + '</option>');
                                });
                            }
                        }
                        else {
                            if (action == 'add') {
                                $('#class-major').empty();
                            }
                            else {
                                $('#modify-class-major').empty();
                            }
                            window.console.log(result.code + ':' + result.desc);
                        }
                    }
                });
            } else {
                if (action == 'add') {
                    $('#class-major').empty().val('');
                } else {
                    $('#modify-class-major').empty().val('');
                }
            }

        });
        $('#class-submit').on('click', function () {
            if ($('#class-name').val() != '') {
                $.ajax({
                    url: '/Ajax/classAjax.php',
                    type: 'post',
                    data: { action: 'add',classid:$('#class-name').val(),schoolid:$('#class-school').val(),majorid:$('#class-major').val() },
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
                $('#class-tip').html('班级号不能为空!');
                window.setTimeout(function () {
                    $('#class-tip').html('');
                }, 3000);
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
            deleClass(ids);
        });
        $('#modify-class-submit').click(function () {
            if (confirm('确认修改班级,该操作将影响班级下所有的学生信息?')) {
                $.ajax({
                    url: '/Ajax/classAjax.php',
                    type: 'post',
                    data: { action: 'modify',oldclassid:$('#modify-class-oldname'), classid: $('#modify-class-name').val(), schoolid: $('#modify-class-school').val(), majorid: $('#modify-class-major').val() },
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
        });
    });
    function modifyClass(id) {
        var $tr = $('#' + id);
        $('#modify-class-oldname').val(id);
        $('#modify-class-name').val(id);
        $('#modify-class-school').val($tr.find('td:eq(3)').data('tag'));
        $.ajax({
            url: '/Ajax/majorAjax.php',
            type: 'get',
            data: { action: 'getlist', schoolid: $tr.find('td:eq(3)').data('tag') },
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        $('#modify-class-major').append('<option value='+item.id+'>'+item.name+'</option>');
                    });
                    $('#modify-class-major').val($tr.find('td:eq(2)').data('tag'));
                }
                else {
                    window.console.log(result.code+':'+result.desc);
                }
            }
        });
        $('#btn-modify-class-mod').trigger('click');
    }
    function deleClass(id) {
        if (!(id instanceof Array)) {
            id = [id];
        }
        if (confirm('确认删除班级,该操作将删除该班级下所有的学生信息?')) {
            $.ajax({
                url: '/Ajax/classAjax.php',
                type: 'post',
                data: { action: 'dele', classid: id },
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
    }
</script>

<?php include dirname(__FILE__).'/../includes/footer.php';?>