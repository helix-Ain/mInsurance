<?php
include dirname(__FILE__).'/../includes/header.php';
if(!$role['admin']) {
    echo 'Access Denied';
    exit;
}
?>
<div class="modal fade" id="level-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="level-modal-title" class="modal-title">添加学奖金</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <div class="form-group">
                            <label for="level-levelname">奖学金名称:</label>
                            <input type="text" class="form-control" id="level-levelname" />
                        </div>
                        <div class="form-group">
                            <label for="level-money">奖学金金额:</label>
                            <input type="date" class="form-control" id="level-money" />
                        </div>
                        <div class="=form-group">
                            <label for="level-note">备注:</label>
                            <input type="text" class="form-control" id="level-note" />
                        </div><br />
                        <button id="level-submit" type="button" class="btn btn-default">提交</button>
                        <span id="level-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modify-level-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="modify-level-modal-title" class="modal-title">修改奖学金信息</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <input type="hidden" id="modify-level-id" />
                        <div class="form-group">
                            <label for="modify-level-level">奖学金名称:</label>
                            <input type="text" class="form-control" id="modify-level-levelname" />
                        </div>
                        <div class="form-group">
                            <label for="modify-level-starttime">奖学金金额:</label>
                            <input type="date" class="form-control" id="modify-level-money" />
                        </div>
                        <div class="=form-group">
                            <label for="modify-level-note">备注:</label>
                            <input type="text" class="form-control" id="modify-level-note" />
                        </div><br />
                        <button id="modify-level-submit" type="button" class="btn btn-default">保存</button>
                        <span id="modify-level-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<button id="btn-modify-level-mod" style="display:none;" data-toggle="modal" data-target="#modify-level-mod"></button>
<div class="main-wrap">
    <div style="margin-top:1px;">
        <div class="crumb-wrap">
            <div class="crumb-list">
                <i class="icon-font" style="margin-left:-25px;"></i>
                <a href="/index.php">首页</a>
                <span class="crumb-step">&gt;</span>
                <span>奖学金管理</span>
            </div>
        </div>
        <div class="result-wrap" id="wrap1">
            <div class="result-title" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
                <div class="result-list">
                    <a href="#" id="allRemove">
                        <span class="glyphicon glyphicon-trash"></span>
                        批量删除
                    </a>
                    <a href="#" data-toggle="modal" data-target="#level-mod">
                        <span class="glyphicon glyphicon-plus"></span>
                        添加奖学金
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
                            <th>奖学金名称</th>
                            <th>奖学金金额</th>
                            <th>备注</th>
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
            url: '/Ajax/scholarshiplevelAjax.php',
            type: 'get',
            data:{action:'getlist'},
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        var day = new Date(item.logintime * 1000);
                        $('#listview tbody').append('<tr id='+item.id+'><td class="tc"><input type="checkbox" name="' + item.id + '"/></td><td>' + item.levelname + '</td><td>'+item.money+'</td><td>'+ isNull(item.note)+'</td><td><a class="btn btn-info btn-xs" onclick="modifylevel('+item.id+')">修改</a><a style="margin-left:5px;" class="btn btn-danger btn-xs" onclick="delelevel('+item.id+')">删除</a></td></tr>');
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
        $('#level-submit').on('click', function () {
            if ($('#level-levelname').val() != '' &&$('#level-money').val()!=''&& $('#level-note').val() != '') {
                $.ajax({
                    url: '/Ajax/scholarshiplevelAjax.php',
                    data: { action: 'add', levelname: $('#level-levelname').val(), money:$('#level-money').val(),note: $('#level-note').val()},
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
                $('#level-tip').html('请填写相关奖学金信息!');
                window.setTimeout(function () {
                    $('#level-tip').html('');
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
                delelevel(ids);
        });
        $('#modify-level-submit').click(function () {
            $.ajax({
                url: '/Ajax/scholarshiplevel.php',
                type: 'post',
                data: { action:'modify',id:$('#modify-level-id').val(),levelname: $('#modify-level-levelname').val(), money: $('#modify-level-money').val(), note: $('#modify-level-note').val()},
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
    function modifylevel(id) {
        var $tr = $('#' + id);
        $('#modify-level-id').val(id);
        $('#modify-level-levelname').val($tr.find('td:eq(1)').html());
        $('#modify-level-money').val($tr.find('td:eq(2)').html());
        $('#modify-level-note').val($tr.find('td:eq(3)').html());
        $('#btn-modify-level-mod').trigger('click');
    }
    function delelevel(id) {
            if (!(id instanceof Array)) {
                id = [id];
            }
            if (confirm('确认删除?')) {
                $.ajax({
                    url: '/Ajax/scholarshiplevelAjax.php',
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