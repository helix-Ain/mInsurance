<?php
include dirname(__FILE__).'/../includes/header.php';
if(!$role['admin']) {
    echo 'Access Denied';
    exit;
}
?>
<div class="modal fade" id="term-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="term-modal-title" class="modal-title">添加学期</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <div class="form-group">
                            <label for="term-title">学期标识:</label>
                            <input type="text" class="form-control" id="term-title" />
                        </div>
                        <div class="form-group">
                            <label for="term-starttime">开始时间:</label>
                            <input type="date" class="form-control" id="term-starttime"/>
                        </div>
                        <div class="form-group">
                            <label for="term-endtime">结束时间:</label>
                            <input type="date" class="form-control" id="term-endtime" />
                        </div>
                        <div class="form-group">
                            <label for="term-enabled">状态:</label>
                            <select class="form-control" id="term-enabled">
                                <option value="1">启用</option>
                                <option value="0">禁用</option>
                            </select>
                        </div>
                        <button id="term-submit" type="button" class="btn btn-default">提交</button>
                        <span id="term-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modify-term-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="modify-term-modal-title" class="modal-title">修改学期信息</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <input type="hidden" id="modify-term-id" />
                        <div class="form-group">
                            <label for="modify-term-title">学期标识:</label>
                            <input type="text" class="form-control" id="modify-term-title" />
                        </div>
                        <div class="form-group">
                            <label for="modify-term-starttime">开始时间:</label>
                            <input type="date" class="form-control" id="modify-term-starttime"/>
                        </div>
                        <div class="form-group">
                            <label for="modify-term-endtime">结束时间:</label>
                            <input type="date" class="form-control" id="modify-term-endtime" />
                        </div>
                        <div class="form-group">
                            <label for="modify-term-enabled">状态:</label>
                            <select class="form-control" id="modify-term-enabled">
                                <option value="1">启用</option>
                                <option value="0">禁用</option>
                            </select>
                        </div>
                        <button id="modify-term-submit" type="button" class="btn btn-default">保存</button>
                        <span id="modify-term-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<button id="btn-modify-term-mod" style="display:none;" data-toggle="modal" data-target="#modify-term-mod"></button>
<div class="main-wrap">
    <div style="margin-top:1px;">
        <div class="crumb-wrap">
            <div class="crumb-list">
                <i class="icon-font" style="margin-left:-25px;"></i>
                <a href="/index.php">首页</a>
                <span class="crumb-step">&gt;</span>
                <span>分学期管理</span>
            </div>
        </div>
        <div class="result-wrap" id="wrap1">
            <div class="result-title" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
                <div class="result-list">
                    <a href="#" id="allRemove">
                        <span class="glyphicon glyphicon-trash"></span>
                        批量删除
                    </a>
                    <a href="#" data-toggle="modal" data-target="#term-mod">
                        <span class="glyphicon glyphicon-plus"></span>
                        添加学期
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
                            <th>学期标识</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th style="width:5.5%;">状态</th>
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
            url: '/Ajax/scholarshiptermAjax.php',
            type: 'get',
            data:{action:'getlist'},
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        var day = new Date(item.logintime * 1000);
                        $('#listview  tbody').append('<tr id='+item.id+'><td class="tc"><input type="checkbox" name="' + item.id + '"/></td><td>' + item.title + '</td><td>'+item.starttime+'</td><td>'+item.endtime+'</td><td>'+checkEnabled(item.enabled,item.id)+'</td><td><a class="btn btn-info btn-sm" onclick="modifyterm('+item.id+')">修改</a><a style="margin-left:5px;" class="btn btn-danger btn-sm" onclick="deleterm('+item.id+')">删除</a></td></tr>');
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
        $('#term-submit').on('click', function () {
            if ($('#term-title').val() != '' &&$('#term-starttime').val()!=''&& $('#term-endtime').val() != '' && $('#term-enabled').val() != '') {
                $.ajax({
                    url: '/Ajax/scholarshiptermAjax.php',
                    data: { action: 'add', title: $('#term-title').val(), starttime:$('#term-starttime').val(),endtime: $('#term-endtime').val(), enabled: $('#term-enabled').val()},
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
                $('#term-tip').html('请填写相关学期信息!');
                window.setTimeout(function () {
                    $('#term-tip').html('');
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
                deleterm(ids);
        });
        $('#modify-term-submit').click(function () {
            if (confirm('确认修改学期,该操作将修改学期下所有的授奖信息?'))
            $.ajax({
                url: '/Ajax/scholarshiptermAjax.php',
                type: 'post',
                data: { action:'modify',id:$('#modify-term-id').val(),title: $('#modify-term-title').val(), starttime: $('#modify-term-starttime').val(), endtime: $('#modify-term-endtime').val(), enabled: $('#modify-term-enabled').val() },
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
    function modifyterm(id) {
        var $tr = $('#' + id);
        $('#modify-term-id').val(id);
        $('#modify-term-title').val($tr.find('td:eq(1)').html());
        $('#modify-term-starttime').val($tr.find('td:eq(2)').html());
        $('#modify-term-endtime').val($tr.find('td:eq(3)').html());
        if ($tr.find('td:eq(4)').children(0).html() == '启用') {
            $('#modify-term-enabled').val(1);
        } else {
            $('#modify-term-enabled').val(0);
        }
        $('#btn-modify-term-mod').trigger('click');
    }
    function deleterm(id) {
            if (!(id instanceof Array)) {
                id = [id];
            }
            if (confirm('确认删除学期,该操作将删除学期下所有的授奖信息?')) {
                $.ajax({
                    url: '/Ajax/scholarshiptermAjax.php',
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
    function checkEnabled(enabled,id) {
        if (enabled == 1) {
            return '<span style="font-weight:100;cursor:pointer;" class="label label-success label-xs" onclick="enabledTransform.call(this,'+id+')">启用</span>';
        } else {
            return '<span style="font-weight:100;cursor:pointer;" class="label label-default label-xs" onclick="enabledTransform.call(this,'+id+')">禁用</span>';
        }
    }
    function enabledTransform(id){
        var $this = $(this);
        if ($this.html() == '启用') {
            var enabled = 0;
        } else {
            var enabled = 1;
        }
        $.ajax({
            url: '/Ajax/scholarshiptermAjax.php',
            type: 'post',
            data:{action:'modify',id:id,enabled:enabled},
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    if (enabled == 1) {
                        $this.removeClass('label-default').addClass('label-success').html('启用');
                    } else {
                        $this.removeClass('label-success').addClass('label-default').html('禁用');
                    }
                } else {
                    window.console.log(result.code+':'+result.desc);
                }
            }
        });
    }
</script>

<?php include dirname(__FILE__).'/../includes/footer.php';?>