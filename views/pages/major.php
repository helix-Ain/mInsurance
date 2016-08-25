<?php
include dirname(__FILE__).'/../includes/header.php';
if(!($role['admin']|| $role['teacher'])) {
    echo 'Access Denied';
    exit;
}
?>
<div class="modal fade" id="major-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="major-modal-title" class="modal-title">添加专业</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <div class="form-group">
                            <label for="major-name">专业名称:</label>
                            <input type="text" class="form-control" id="major-name" />
                        </div>
                        <div class="form-group">
                            <label for="major-school">所属学院:</label>
                            <select id="major-school" class="form-control">
                            </select>
                        </div>
                        <button id="major-submit" type="button" class="btn btn-default">提交</button>
                        <span id="major-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modify-major-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="major-modal-title" class="modal-title">添加专业</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <input type="hidden" id="modify-major-id" />
                        <div class="form-group">
                            <label for="modify-major-name">专业名称:</label>
                            <input type="text" class="form-control" id="modify-major-name" />
                        </div>
                        <div class="form-group">
                            <label for="modify-major-school">所属学院:</label>
                            <select id="modify-major-school" class="form-control"></select>
                        </div>
                        <button id="modify-major-submit" type="button" class="btn btn-default">保存</button>
                        <span id="major-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<button id="btn-modify-major-mod" style="display:none;" data-toggle="modal" data-target="#modify-major-mod"></button>
<div class="main-wrap">
    <div style="margin-top:1px;">
        <div class="crumb-wrap">
            <div class="crumb-list">
                <i class="icon-font" style="margin-left:-25px;"></i>
                <a href="/index.php">首页</a>
                <span class="crumb-step">&gt;</span>
                <span>专业管理</span>
            </div>
        </div>
        <div class="result-wrap" id="wrap1">
            <div class="result-title" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
                <div class="result-list">
                    <a href="#" id="allRemove">
                        <span class="glyphicon glyphicon-trash"></span>
                        批量删除
                    </a>
                    <a href="#" data-toggle="modal" data-target="#major-mod">
                        <span class="glyphicon glyphicon-plus"></span>
                        添加专业
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
                            <th>专业名称</th>
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
            url: '/Ajax/majorAjax.php',
            data:{action:'getlist'},
            type: 'get',
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        $('#listview tbody').append('<tr id='+item.id+'><td class="tc"><input type="checkbox" name="'+item.id+'"/></td><td>'+item.name+'</td><td data-tag='+item.schoolid+'>'+item.school+'</td><td><a class="btn btn-info btn-xs" onclick="modifyMajor('+item.id+')">修改</a><a style="margin-left:5px;" class="btn btn-danger btn-xs" onclick="deleMajor('+item.id+')">删除</a></td></tr>');
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
                        $('#major-school').append('<option value=' + item.id + '>' + item.name + '</option>');
                        $('#modify-major-school').append('<option value='+item.id+'>'+item.name+'</option>');
                    });
                }
                else {
                    window.console.log(result.code+':'+result.desc);
                }
            }
        });
        $('#major-submit').on('click', function () {
            if ($('#major-name').val() != '' && $('#major-school').val() != '') {
                $.ajax({
                    url: '/Ajax/majorAjax.php',
                    data: { action: 'add', name: $('#major-name').val(), schoolid: $('#major-school').val() },
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
                $('#major-tip').html('专业名称和所属学院不能为空!');
                window.setTimeout(function () {
                    $('#major-tip').html('');
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
            deleMajor(ids);
        });
        $('#modify-major-submit').click(function () {
            $.ajax({
                url: '/Ajax/majorAjax.php',
                type: 'post',
                data: { action: 'modify', id: $('#modify-major-id').val(), name: $('#modify-major-name').val(), schoolid: $('#modify-major-school').val() },
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

    function modifyMajor(id) {
        var $tr = $('#'+id);
        $('#modify-major-id').val(id);
        $('#modify-major-name').val($tr.find('td:eq(1)').html());
        $('#modify-major-school').val($tr.find('td:eq(2)').data('tag'));
        $('#btn-modify-major-mod').trigger('click');
    }

    function deleMajor(id) {
        if (!(id instanceof Array)) {
            id = [id];
        }
        if (confirm('确认删除?')) {
            $.ajax({
                url: '/Ajax/majorAjax.php',
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