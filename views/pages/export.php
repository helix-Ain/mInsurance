<?php
include __DIR__.'/../includes/header.php';
if( !($role['admin']||$role['teacher'])) {
    echo 'Access Denied';
    exit;
}
?>
<div class="modal fade" id="modify-student-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="student-modal-title" class="modal-title">修改学生信息</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <input type="hidden" id="modify-student-oldstuid" />
                        <div class="form-group">
                            <label for="modify-student-stuid">学号:</label>
                            <input type="text" class="form-control" id="modify-student-stuid" />
                        </div>
                        <div class="form-group">
                            <label for="modify-student-name">姓名:</label>
                            <input type="text" class="form-control" id="modify-student-name" />
                        </div>
                        <div class="form-group">
                            <label for="modify-student-identification">身份证:</label>
                            <input type="text" class="form-control" id="modify-student-identification" />
                        </div>
                        <div class="form-group">
                            <label>性别:</label><br />
                            <label class="radio-inline">
                                &nbsp;&nbsp;<input type="radio" name="modify-student-sex" id="man" value="男">男
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="modify-student-sex" value="女" id="woman">女
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="modify-student-birthday">出生年月:</label>
                            <input type="date" class="form-control" id="modify-student-birthday" />
                        </div>
                        <div class="form-group">
                            <label for="modify-student-school">学院:</label>
                            <select class="form-control" id="modify-student-school"></select>
                        </div>
                        <div class="form-group">
                            <label for="modify-student-major">专业:</label>
                            <select class="form-control" id="modify-student-major"></select>
                        </div>
                        <div class="form-group">
                            <label for="modify-student-classid">班级:</label>
                            <select class="form-control" id="modify-student-classid"></select>
                        </div>
                        <div class="form-group">
                            <label for="modify-student-insured">参保:</label>
                            <select class="form-control" id="modify-student-insured">
                                <option value="0">未参保</option>
                                <option value="1">已参保</option>
                            </select>
                        </div>
                        <div class="=form-group">
                            <label for="modify-student-note">备注:</label>
                            <input type="text" class="form-control" id="modify-student-note" />
                        </div><br />
                        <button id="modify-student-submit" type="button" class="btn btn-default">保存</button>
                        <span id="student-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="export-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="export-title" class="modal-title">条件导出</h4>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <div class="form-group">
                            <label for="export-school">学院:</label>
                            <select class="form-control" id="export-school"></select>
                        </div>
                        <div class="form-group">
                            <label for="export-major">专业:</label>
                            <select class="form-control" id="export-major"></select>
                        </div>
                        <div class="form-group">
                            <label for="export-classid">班级:</label>
                            <select class="form-control" id="export-classid"></select>
                        </div>
                        <div class="form-group">
                            <label for="export-insured">参保:</label>
                            <select class="form-control" id="export-insured">
                                <option value="">全部</option>
                                <option value="1">已参保</option>
                                <option value="0">未参保</option>
                            </select>
                        </div><br />
                        <div class="form-group">
                            <label for="export-field">导出字段:</label><br />
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="school" checked />学院
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="major" checked />专业
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="classid" checked />班级
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="stuid" checked />学号
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="name" checked />姓名
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="identification" checked />身份证号码
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="sex" checked />性别
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="birthday" checked />出生年月
                            </label><br />
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="insured" checked />参保
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" class="export-field" value="note" checked />备注
                            </label>
                        </div>
                        <button id="export-submit" type="button" class="btn btn-default">导出</button>
                        <span id="export-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<button style="display:none;" id="btn-modify-student-mod" data-toggle="modal" data-target="#modify-student-mod"></button>
<div class="main-wrap">
    <div style="margin-top:1px;">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font" style="margin-left:-25px;"></i><a href="/index.php">首页</a><span class="crumb-step">&gt;</span><span>导出学生</span></div>
        </div>
        <div class="result-wrap" id="wrap1">
            <div class="result-title" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
                <div class="result-list">
                    <a href="#" id="allRemove">
                        <span class="glyphicon glyphicon-trash"></span>
                        批量删除
                    </a>
                    <a href="#" data-toggle="modal" data-target="#export-mod">
                        <span class="glyphicon glyphicon-file"></span>
                        导出表格
                    </a>
                </div>
            </div>
            <div class="result-content">
                <table id="listview" class="result-tab" style="width: 100%;display:none;">
                    <thead>
                        <tr>
                            <th class="tc" style="width: 10px;">
                                <input class="allChoose" name="allChoose" id="allChoose" type="checkbox" />
                            </th>
                            <th>学号</th>
                            <th>姓名</th>
                            <th>身份证</th>
                            <th>性别</th>
                            <th>出生年月</th>
                            <th>班级</th>
                            <th>专业</th>
                            <th>学院</th>
                            <th>参保</th>
                            <th>备注</th>
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
            url: '/Ajax/studentAjax.php',
            data:{action:'getlist'},
            type: 'get',
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $.each(result.data, function (i, item) {
                        if (item.insured == 0) {
                            var insured = '<span style="cursor:pointer;font-weight:100;" class="label label-default label-xs" onclick="insuredTransform.call(this,'+item.stuid+')">未参保</span>';
                        } else {
                            var insured = '<span style="cursor:pointer;font-weight:100;" class="label label-success label-xs" onclick="insuredTransform.call(this,'+item.stuid+')">已参保</span>';
                        }
                        $('#listview tbody').append('<tr id=' + item.stuid + '><td class="tc"><input type="checkbox" class="tc-input" name="' + item.stuid + '"/></td><td>' + item.stuid + '</td><td>' + item.name + '</td><td>' + item.identification + '</td><td>' + item.sex + '</td><td>' + item.birthday + '</td><td>' + item.classid + '</td><td>' + item.major + '</td><td data-schoolid='+item.schoolid+'>' + item.school + '</td><td>'+insured+'</td><td>' + item.note + '</td><td><a class="btn btn-info btn-sm" onclick="modifyStudent(' + item.stuid + ')">修改</a><a style="margin-left:5px;" class="btn btn-danger btn-sm" onclick="deleStudent(' + item.stuid + ')">删除</a></td></tr>');
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
                $('input.tc-input[type="checkbox"]').prop('checked', true);
            }
            else {
                $('input.tc-input[type="checkbox"]').prop('checked', false);
            }
        });
        $('#allRemove').click(function () {
            var ids = [];
            $.each($('input.tc-input[type="checkbox"]:checked'), function () {
                if ($(this).attr('name') == 'allChoose') {
                    return true;
                }
                ids.push($(this).attr('name'));
            });
            deleStudent(ids);
        });
        $('#modify-student-submit').click(function () {
            if (confirm('确认修改学生,该操作将影响学生下所有的奖学金信息?'))
            $.ajax({
                url: '/Ajax/studentAjax.php',
                type: 'post',
                data: { action: 'modify',oldstuid:$('#modify-student-oldstuid').val(), stuid: $('#modify-student-stuid').val(), name: $('#modify-student-name').val(), identification: $('#modify-student-identification').val(), sex: $('input[name="modify-student-sex"]:checked').val(), birthday: $('#modify-student-birthday').val(), school: $('#modify-student-school').val(), major: $('#modify-student-major').val(), class: $('#modify-student-class').val(), note: $('#modify-student-note').val() },
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
        $.ajax({
            url: '/Ajax/schoolAjax.php',
            type: 'get',
            data: { action: 'getlist' },
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    $('#export-school,#modify-student-school').append('<option value="">请选择</option>');
                    $.each(result.data, function (i, item) {
                        $('#export-school').append('<option value=' + item.id + '>' + item.name + '</option>');
                        $('#modify-student-school').append('<option value='+item.name+'>'+item.name+'</option>');
                    });
                }
                else {
                    window.console.log(result.code+':'+result.desc);
                }
            }
        });

        $('#export-school').change(function () {
            $('#export-major,#export-classid').empty().val('');
            if ($(this).val() != '') {
                $.ajax({
                    url: '/Ajax/majorAjax.php',
                    type: 'get',
                    data: { action: 'getlist', schoolid: $('#export-school').val() },
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            $('#export-major').append('<option value="">请选择</option>');
                            $.each(result.data, function (i, item) {
                                $('#export-major').append('<option value='+item.id+'>'+item.name+'</option>');
                            });
                        }
                        else {
                            window.console.log(result.code + ':' + result.desc);
                        }
                    }
                });
            }
        });

        $('#export-major').change(function () {
            $('#export-classid').empty().val('');
            if ($(this).val() != '') {
                $.ajax({
                    url: '/Ajax/classAjax.php',
                    type: 'get',
                    data: { action: 'getlist', schoolid: $('#export-school').val(), majorid: $('#export-major').val() },
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            $('#export-classid').append('<option value="">请选择</option>');
                            $.each(result.data, function (i, item) {
                                $('#export-classid').append('<option value=' + item.classid + '>' + item.classid + '</option>');
                            });
                        }
                        else {
                            window.console.log(result.code + ':' + result.desc);
                        }
                    }
                });
            }
        });

        $('#modify-student-major').change(function(){
            $('#modify-student-class').empty().val('');
            $.ajax({
                url: '/Ajax/classAjax.php',
                type: 'get',
                data: {action:'getlist',major:$(this).val()},
                dataType:'json',
                success: function(result){
                    if(result.code==0){
                         $('#modify-student-class').append('<option value="">请选择</option>');
                         $.each(result.data,function(i,item){
                             $('#modify-student-class').append('<option value='+item.classid+'>'+item.classid+'</option>');
                         });
                    }
                    else{
                        window.console.log(result.code+':'+result.desc);
                    }
                }
            });
        });
        $('#export-submit').click(function () {
            var fields = [];
            $.each($('.export-field:checked'), function (i, item) {
                fields.push($(this).val());
            });
            var school = $("#export-school").val();
            var major = $("#export-major").val();
            var class_ = $("#export-classid").val();
            var insured = $('#export-insured').val();
            location.href = '/Ajax/studentAjax.php?action=export&school='+school+'&major='+major+'&classid='+class_+'&insured='+insured+'&fields='+fields;
        });
    });
    function modifyStudent(stuid) {
        $('#modify-student-oldstuid').val(stuid);
        $('#modify-student-major,#modify-student-classid').empty();
        var $tr = $('#' + stuid);
        var school = $tr.find('td:eq(8)').html();
        var major = $tr.find('td:eq(7)').html();
        var classid = $tr.find('td:eq(6)').html();
        $('#modify-student-school').val(school);
        $.ajax({
            url:'/Ajax/majorAjax.php',
            type:'get',
            data: {action:'getlist',school:school},
            dataType:'json',
            success: function (result) {
                if (result.code == 0) {
                    $('#modify-student-major').append('<option value="">请选择</option>');
                    $.each(result.data, function (i, item) {
                            $('#modify-student-major').append('<option value=' + item.name + ' > ' + item.name + '</option>');    
                    });
                    $('#modify-student-major').val(major);
                    $.ajax({
                        url: '/Ajax/classAjax.php',
                        type:'get',
                        data: { action: 'getlist', major: major },
                        dataType: 'json',
                        success: function (result) {
                            if (result.code == 0) {
                                $('#modify-student-classid').append('<option value="">请选择</option>');
                                $.each(result.data, function (i, item) {
                                    $('#modify-student-classid').append('<option value=' + item.classid + '>' + item.classid + '</option>');
                                });
                                $('#modify-student-classid').val(classid);
                            } else {
                                window.console.log(result.code+':'+result.desc);
                            }
                        }
                    });
                }
                else{
                      window.console.log(result.code+':'+result.desc);
                }
            }
        });
        $('#modify-student-stuid').val($tr.find('td:eq(1)').html());
        $('#modify-student-name').val($tr.find('td:eq(2)').html());
        $('#modify-student-identification').val($tr.find('td:eq(3)').html());
        if ($tr.find('td:eq(4)').html() == '男') {
            $('#man').prop('checked',true);
        }
        else {
            $('#woman').prop('checked',true);
        }
        $('#modify-student-birthday').val($tr.find('td:eq(5)').html());
        if ($tr.find('td:eq(9)').children(0).html() == '未参保') {
            $('#modify-student-insured').val(0);
        } else {
            $('#modify-student-insured').val(1);
        }
        $('#modify-student-note').val($tr.find('td:eq(10)').html());
        $('#btn-modify-student-mod').trigger('click');
    }
    function deleStudent(id) {
        if (!(id instanceof Array)) {
            id = [id];
        }
        if (confirm('确认删除学生,该操作将删除学生下所有的获奖信息?')) {
            $.ajax({
                url: '/Ajax/studentAjax.php',
                type: 'post',
                data: { action:'dele',stuid: id },
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
    function insuredTransform(stuid) {
        var $this = $(this);
        if ($this.html() == '未参保') {
            var insured = 1;
        }else {
            var insured = 0;
        }
        $.ajax({
            url: '/Ajax/studentAjax.php',
            type: 'post',
            data: { action: 'modify', stuid: stuid, insured: insured },
            dataType: 'json',
            success: function (result) {
                if (result.code == 0) {
                    if (insured == 1) {
                        $this.removeClass('label-default').addClass('label-success').html('已参保');
                    } else {
                        $this.removeClass('label-success').addClass('label-default').html('未参保');
                    }
                } else {
                    window.console.log(result.code+':'+result.desc);
                }
            }
        });
    }
</script>

<?php include __DIR__.'/../includes/footer.php';?>