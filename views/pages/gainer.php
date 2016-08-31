<?php
include dirname(__FILE__) . '/../includes/header.php';
if (!($role['admin']||$role['teacher'])) {
	echo 'Access Denied';
	exit ;
}
?>
<div class="modal fade" id="gainer-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<h4 id="gainer-modal-title" class="modal-title">添加获奖人信息</h4>
			</div>
			<div class="modal-body">
				<div>
					<form>
						<div class="form-group">
							<label for="gainer-stuid">学号:</label>
							<input type="text" class="form-control" id="gainer-stuid" />
						</div>
						<div class="form-group">
							<label for="gainer-levelid">奖学金:</label>
							<select class="form-control" id="gainer-levelid"></select>
						</div>
						<div class="=form-group">
							<label for="gainer-termid">学期:</label>
							<select class="form-control" id="gainer-termid"></select>
						</div>
						<br />
						<button id="gainer-submit" type="button" class="btn btn-default">
						提交
						</button>
						<span id="gainer-tip" style="color: red; margin-left: 15px;"></span>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
				关闭
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modify-gainer-mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				<h4 id="modify-gainer-modal-title" class="modal-title">修改获奖人信息</h4>
			</div>
			<div class="modal-body">
				<div>
					<form>
						<input type="hidden" id="modify-gainer-id" />
						<div class="form-group">
							<label for="modify-gainer-stuid">学号:</label>
							<input type="text" class="form-control" id="modify-gainer-stuid" readonly="readonly" />
						</div>
						<div class="form-group">
							<label for="modify-gainer-levelid">奖学金:</label>
							<select class="form-control" id="modify-gainer-levelid"></select>
						</div>
						<div class="=form-group">
							<label for="modify-gainer-termid">学期:</label>
							<select class="form-control" id="modify-gainer-termid"></select>
						</div>
						<br />
						<button id="modify-gainer-submit" type="button" class="btn btn-default">
						保存
						</button>
						<span id="modify-gainer-tip" style="color: red; margin-left: 15px;"></span>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
				关闭
				</button>
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
							<label for='export-levelid'>奖学金名称:</label>
							<select class='form-control' id='export-levelid'></select>
						</div>
                        <div class='form-group'>
                        	<label for='export-termid'>奖学金学期:</label>
                        	<select class='form-control' id='export-termid'></select>
                        </div>
						<div class="form-group">
							<label for="export-field">字段:</label>
							<br/>
                            <label class="checkbox-inline">
                            <input type="checkbox" class="export-field" value="levelname" checked />
                            奖学金</label>
                            <label class="checkbox-inline">
                            <input type="checkbox" class="export-field" value="money" checked />
                            金额</label>
                            <label class="checkbox-inline">
                            <input  type="checkbox" class="export-field" value="term" checked />
                             学期</label>
							<label class="checkbox-inline">
							<input type="checkbox" class="export-field" value="school" checked/>
							学院 </label>
							<label class="checkbox-inline">
							<input type="checkbox" class="export-field" value="major" checked />
							专业 </label>
							<label class="checkbox-inline">
							<input type="checkbox" class="export-field" value="classid" checked/>
							班级 </label>
							<label class="checkbox-inline">
							<input type="checkbox" class="export-field" value="stuid" checked/>
							学号 </label>
							<label class="checkbox-inline">
							<input type="checkbox" class="export-field" value="name" checked/>
                                姓名
                            </label><br />
                            <label class="checkbox-inline">
							<input type="checkbox" class="export-field" value="identification" checked/>
							身份证号码 </label>
							<label class="checkbox-inline">
							<input type="checkbox" class="export-field" value="sex" checked/>
							性别 </label>
							<label class="checkbox-inline">
							<input type="checkbox" class="export-field" value="birthday" checked/>
							出生年月 </label>
							<label class="checkbox-inline">
							<input type="checkbox" class="export-field" value="note" checked/>
							备注 </label>
						</div>
						<button id="export-submit" type="button" class="btn btn-default">
						导出
						</button>
						<span id="export-tip" style="color: red; margin-left: 15px;"></span>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
				关闭
				</button>
			</div>
		</div>
	</div>
</div>
<button id="btn-modify-gainer-mod" style="display:none;" data-toggle="modal" data-target="#modify-gainer-mod"></button>
<div class="main-wrap">
	<div style="margin-top:1px;">
		<div class="crumb-wrap">
			<div class="crumb-list">
				<i class="icon-font" style="margin-left:-25px;"></i>
				<a href="/index.php">
					首页
				</a>
				<span class="crumb-step">&gt;</span>
				<span>获奖人列表</span>
			</div>
		</div>
		<div class="result-wrap" id="wrap1">
			<div class="result-title" style="border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
				<div class="result-list">
					<a href="#" id="allRemove">
						<span class="glyphicon glyphicon-trash"></span>
						批量删除
					</a>
					<a href="#" data-toggle="modal" data-target="#gainer-mod">
						<span class="glyphicon glyphicon-plus"></span>
						添加获奖人
					</a>
					<a href="#" data-toggle="modal" data-target="#export-mod">
						<span class='glyphicon glyphicon-file'></span>
						导出表格
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
							<th>学号</th>
							<th>姓名</th>
							<th>性别</th>
							<th>班级</th>
							<th>专业</th>
							<th>学院</th>
							<th>奖学金</th>
					        <th>学期</th>
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
<script>$(function() {
	$.ajax({
		url: '/Ajax/scholarshipgainerAjax.php',
		type: 'get',
		data: {
			action: 'getlist'
		},
		dataType: 'json',
		success: function (result) {
		    if (result.code == 0) {
				$.each(result.data, function(i, item) {
					var day = new Date(item.logintime * 1000);
					$('#listview tbody').append('<tr id=' + item.id + '><td class="tc"><input type="checkbox" name="' + item.id + '"/></td><td>' + item.stuid + '</td><td>' + item.name + '</td><td>' + item.sex + '</td><td>' + item.classid + '</td><td>' + item.major + '</td><td>' + item.school + '</td><td data-levelid='+item.levelid+'>' + item.levelname + '</td><td data-termid='+item.termid+'>' + item.term + '</td><td><a class="btn btn-info btn-sm" onclick="modifygainer(' + item.id + ')">修改</a><a style="margin-left:5px;" class="btn btn-danger btn-sm" onclick="delegainer(' + item.id + ')">删除</a></td></tr>');
				});
			} else {
				window.console.log(result.code + ':' + result.desc);
			}
			$('#listview').dataTable({
				//初始化时指定某列不排序
				"aoColumnDefs": [{
					"bSortable": false,
					"aTargets": [0]
				}],
				oLanguage: {
					sUrl: "/public/DataTables-1.10.4/cn.txt"
				}
			});
			$('#listview').fadeIn();
		}
	});
	$.ajax({
		url: '/Ajax/scholarshiplevelAjax.php',
		type: 'get',
		data: {
			action: 'getlist'
		},
		dataType: 'json',
		success: function(result) {
			if(result.code == 0) {
				$('#gainer-levelid,#export-levelid').append('<option value="">请选择</option>');
				$.each(result.data, function(i, item) {
					$('#gainer-levelid,#modify-gainer-levelid,#export-levelid').append('<option value=' + item.id + '>' + item.levelname + '</option>');
				});
			} else {
				window.console.log(result.code + ':' + result.desc);
			}
		}
	});
	$.ajax({
		url: '/Ajax/scholarshiptermAjax.php',
		type: 'get',
		data: {
		    action: 'getlist',
            enabled:1
		},
		dataType: 'json',
		success: function (result) {
		    if (result.code == 0) {        
				$('#gainer-termid,#export-termid').append('<option value="">请选择</option>');
				$.each(result.data, function(i, item) {
					$('#gainer-termid,#modify-gainer-termid,#export-termid').append('<option value=' + item.id + '>' + item.title + '</option>');
				});
			} else {
				window.console.log(result.code + ':' + result.desc);
			}
		}
	});
	$.ajax({
	    url: '/Ajax/schoolAjax.php',
	    type: 'get',
	    data: {
            action:'getlist'
	    },
	    dataType: 'json',
	    success: function (result) {
	        if (result.code == 0) {
	            $('#export-school').append('<option value="">请选择</option>');
	            $.each(result.data, function (i, item) {
	                $('#export-school').append('<option value='+item.id+'>'+item.name+'</option>');
	            });
	        } else {
	            window.console.log(result.code+':'+result.desc);
	        }
	    }
	});
	$('#export-school').change(function () {
	    $('#export-major,#export-classid').empty().val('');
	    var schoolid = $(this).val();
	    if (schoolid != '') {
	        $.ajax({
	            url: '/Ajax/majorAjax.php',
	            type: 'get',
	            data: {
	                action: 'getlist',
                    schoolid:schoolid
	            },
	            dataType: 'json',
	            success: function (result) {
	                if (result.code == 0) {
	                    $('#export-major').append('<option value="">请选择</option>');
	                    $.each(result.data, function (i, item) {
	                        $('#export-major').append('<option value='+item.id+'>'+item.name+'</option>');
	                    });
	                } else {
	                    window.console.log(result.code+':'+result.desc);
	                }
	            }
	        });
	    }
	});
	$('#export-major').change(function () {
	    $('#export-classid').empty().val('');
	    var majorid = $(this).val();
	    if (majorid != '') {
	        $.ajax({
	            url: '/Ajax/classAjax.php',
	            type: 'get',
	            data: {
	                action: 'getlist',
                    majorid:majorid
	            },
	            dataType: 'json',
	            success: function (result) {
	                if (result.code == 0) {
	                    $('#export-classid').append('<option value="">请选择</option>');
	                    $.each(result.data, function (i, item) {
	                        $('#export-classid').append('<option value='+item.classid+'>'+item.classid+'</option>');
	                    });
	                } else {
	                    window.console.log(result.code+':'+result.desc);
	                }
	            }
	        });
	    }
	});
	$('#gainer-submit').on('click', function() {
		if($('#gainer-stuid').val() != '' && $('#gainer-levelid').val() != '' && $('#gainer-termid').val() != '') {
			$.ajax({
				url: '/Ajax/scholarshipgainerAjax.php',
				data: {
					action: 'set',
					stuid: $('#gainer-stuid').val(),
					levelid: $('#gainer-levelid').val(),
					termid: $('#gainer-termid').val()
				},
				type: 'post',
				dataType: 'json',
				success: function(result) {
					if(result.code == 0) {
						location.reload();
					} else {
					    alert(result.desc+':请检查该学号是否存在!');
						window.console.log(result.code + ':' + result.desc);
					}
				}
			});
		} else {
			$('#gainer-tip').html('请填写相关获奖人信息!');
			window.setTimeout(function() {
				$('#gainer-tip').html('');
			}, 3000);
		}
	});
	$('#allChoose').change(function() {
		if($('#allChoose').prop('checked') == true) {
			$('input[type="checkbox"]').prop('checked', true);
		} else {
			$('input[type="checkbox"]').prop('checked', false);
		}
	});
	$('#allRemove').click(function() {
		var ids = [];
		$.each($('input[type="checkbox"]:checked'), function() {
			if($(this).attr('name') == 'allChoose') {
				return true;
			}
			ids.push($(this).attr('name'));
		});
		delegainer(ids);
	});
	$('#modify-gainer-submit').click(function() {
		$.ajax({
			url: '/Ajax/scholarshipgainerAjax.php',
			type: 'post',
			data: {
				action: 'modify',
				id: $('#modify-gainer-id').val(),
                stuid:$('#modify-gainer-stuid').val(),
				levelid: $('#modify-gainer-levelid').val(),
				termid: $('#modify-gainer-termid').val()
			},
			dataType: 'json',
			success: function(result) {
				if(result.code == 0) {
					location.reload();
				} else {
					window.console.log(result.code + ':' + result.desc);
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
	    var levelid = $('#export-levelid').val();
	    var termid = $('#export-termid').val();
	    location.href = '/Ajax/scholarshipgainerAjax.php?action=export&school=' + school + '&major=' + major + '&classid=' + class_ + '&levelid='+levelid+'&termid='+termid+'&fields=' + fields;
	});
});

function modifygainer(id) {
	var $tr = $('#' + id);
	$('#modify-gainer-id').val(id);
	$('#modify-gainer-stuid').val($tr.find('td:eq(1)').html());
	$('#modify-gainer-levelid').val($tr.find('td:eq(7)').data('levelid'));
	$('#modify-gainer-termid').val($tr.find('td:eq(8)').data('termid'));
	$('#btn-modify-gainer-mod').trigger('click');
}

function delegainer(id) {
	if(!(id instanceof Array)) {
		id = [id];
	}
	if (confirm('确认删除奖学金授予记录?')) {
		$.ajax({
			url: '/Ajax/scholarshipgainerAjax.php',
			data: {
				action: 'dele',
				id: id
			},
			type: 'post',
			dataType: 'json',
			success: function(result) {
				if(result.code == 0) {
					location.reload();
				} else {
					window.console.log(result.code + ':' + result.desc);
				}
			}
		});
	}
}</script>

<?php
include dirname(__FILE__) . '/../includes/footer.php';
?>