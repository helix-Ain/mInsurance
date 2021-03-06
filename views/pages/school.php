<?php
include dirname(__FILE__).'/../includes/header.php';
if(!$role['admin']) {
    echo 'Access Denied';
    exit();
}
?>
<div class="modal fade" id="school-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="school-modal-title" class="modal-title">添加学院</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <div class="form-group">
                            <label for="school-name">学院名称:</label>
                            <input type="text" class="form-control" id="school-name" />
                        </div>
                        <div class="form-group">
                            <label for="school-telephone">学院电话:</label>
                            <input type="tel" class="form-control" id="school-telephone" />
                        </div>
                        <div class="form-group">
                            <label for="school-description">学院描述:</label>
                            <input type="text" class="form-control" id="school-description" />
                        </div>
                        <button id="school-submit" type="button" class="btn btn-default">提交</button>
                        <span id="school-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modify-school-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="school-modal-title" class="modal-title">修改学院</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <input type="hidden" id="modify-school-id" />
                        <div class="form-group">
                            <label for="modify-school-name">学院名称:</label>
                            <input type="text" class="form-control" id="modify-school-name" />
                        </div>
                        <div class="form-group">
                            <label for="modify-school-telephone">学院电话:</label>
                            <input type="tel" class="form-control" id="modify-school-telephone" />
                        </div>
                        <div class="form-group">
                            <label for="modify-school-description">学院描述:</label>
                            <input type="text" class="form-control" id="modify-school-description" />
                        </div>
                        <button id="modify-school-submit" type="button" class="btn btn-default">保存</button>
                        <span id="school-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<button id="btn-modify-school-mod" style="display:none;" data-toggle="modal" data-target="#modify-school-mod"></button>
<div class="main-wrap">
    <div style="margin-top:1px;">
        <div class="crumb-wrap">
            <div class="crumb-list">
                <i class="icon-font" style="margin-left:-25px;"></i>
                <a href="/index.php">首页</a>
                <span class="crumb-step">&gt;</span>
                <span>学院管理</span>
            </div>
        </div>
        <div class="result-wrap" id="wrap1">
            <div class="result-title" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
                <div class="result-list">
                    <a href="javascript:" id="allRemove">
                        <span class="glyphicon glyphicon-trash"></span>
                        批量删除
                    </a>
                    <a href="#" data-toggle="modal" data-target="#school-mod">
                        <span class="glyphicon glyphicon-plus" id="btn-add"></span>
                        添加学院
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
                            <th>学院名称</th>
                            <th>电话</th>
                            <th>描述</th>
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
            url: '/Ajax/schoolAjax.php',
            data:{action:'getlist'},
            type: 'get',
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        $('#listview tbody').append('<tr id='+item.id+'><td class="tc"><input type="checkbox" name="' + item.id + '"/></td><td>' + item.name + '</td><td>' + item.telephone + '</td><td>' + item.description + '</td><td><a class="btn btn-info btn-sm" onclick="modifySchool('+item.id+')">修改<a class="btn btn-danger btn-sm" style="margin-left:5px;" onclick="deleSchool('+item.id+')">删除</a></td></tr>');
                    });
                }
                else {
                    window.console.log(result.code + ':' + result.description);
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

        $('#school-submit').on('click', function () {
            if ($('#school-name').val() != '') {
                $.ajax({
                    url: '/Ajax/schoolAjax.php',
                    data: { action: 'add', name: $('#school-name').val(), telephone: $('#school-telephone').val(), description: $('#school-description').val() },
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
                $('#school-tip').html('学院名称不能为空!');
                window.setTimeout(function () {
                    $('#school-tip').html('');
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
            var ids=[];
            $.each($('input[type="checkbox"]:checked'), function () {
                if ($(this).attr('name') == 'allChoose') {
                    return true;
                }
                ids.push($(this).attr('name'));
            });
            deleSchool(ids);
        });
        
        $('#modify-school-submit').click(function () {
            if (confirm('确认修改学院,该操作将影响学院下所有的教师,专业,班级和学生信息?')) {
                $.ajax({
                    url: '/Ajax/schoolAjax.php',
                    type: 'post',
                    data: { action: 'modify', id: $('#modify-school-id').val(), name: $('#modify-school-name').val(), telephone: $('#modify-school-telephone').val(), description: $('#modify-school-description').val() },
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

    function modifySchool(id) {
        var $tr = $('#' + id);
        $('#modify-school-id').val(id);
        $('#modify-school-name').val($tr.find('td:eq(1)').html());
        $('#modify-school-telephone').val($tr.find('td:eq(2)').html());
        $('#modify-school-description').val($tr.find('td:eq(3)').html());
        $('#btn-modify-school-mod').trigger('click');
    }

    function deleSchool(id) {
        if (!(id instanceof Array)) {
            id = [id];
        }
        if (confirm('确认删除学院,该操作将删除学院下所有的教师,专业,班级和学生信息?')) {
            $.ajax({
                url: '/Ajax/schoolAjax.php',
                data: { action: 'dele', id: id },
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
    }

</script>

<?php include dirname(__FILE__).'/../includes/footer.php';?>