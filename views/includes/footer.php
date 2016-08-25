 </div>
<button id="dialog" type="button" style="display: none;" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"></button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="modal-title" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div id="modal-1">
                    <form>
                        <div class="form-group">
                            <label for="old-pwd">旧密码:</label>
                            <input type="text" class="form-control" id="old-pwd">
                        </div>
                        <div class="form-group">
                            <label for="new-pwd">新密码:</label>
                            <input type="password" class="form-control" id="new-pwd">
                        </div>
                        <div class="form-group">
                            <label for="confirm-pwd">再次确认:</label>
                            <input type="password" class="form-control" id="confirm-pwd">
                        </div>
                        <button id="btn-change-pwd" type="button" class="btn btn-default">提交</button>
                        <span id="change-pwd-tip" style="color: red; margin-left: 15px;"></span>
                    </form>
                </div>
                <div id="modal-2">
                    <table class="result-tab" style="border: 1px solid #f2f2f2; width: 100%;">
                        <thead>
                            <tr>
                                <th>账号</th>
                                <th>最后登录时间</th>
                                <th>最后登录ip</th>
                            </tr>
                        </thead>
                        <tbody id="admin-info"></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<script>
        $(function () {
            $('#logout').click(function () {
                $.ajax({
                    url: '/Ajax/userAjax.php?action=logout',
                    type: 'post',
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            window.location.href = '/index.php';
                        }
                    }
                });
            });
            $('#btn-change-pwd').click(function () {
                if ($('#old-pwd').val() != '' && $('#new-pwd').val() != '' && $('#confirm-pwd').val() != '') {
                    if ($('#new-pwd').val() == $('#confirm-pwd').val()) {
                        $.ajax({
                            url: "/Ajax/userAjax.php?action=modifyPassword",
                            type: 'post',
                            dataType: 'json',
                            data: { oldPwd: $('#old-pwd').val(), newPwd: $('#new-pwd').val() },
                            success: function (result) {
                                if (result.code == 0) {
                                    alert('密码修改成功!');
                                    location.href = "/index.php";
                                }
                                else {
                                    $('#change-pwd-tip').html('请检查当前密码是否正确!');
                                    setTimeout(function () {
                                        $('#change-pwd-tip').html('');
                                    }, 2000);
                                }
                            }
                        });
                    }
                    else {
                        $('#change-pwd-tip').html('两次输入的密码不一样!');
                        setTimeout(function () {
                            $('#change-pwd-tip').html('');
                        }, 2000);
                    }
                }
                else {
                    $('#change-pwd-tip').html('请不要留下空项!');
                    setTimeout(function () {
                        $('#change-pwd-tip').html('');
                    }, 2000);
                }
            });
            $.ajax({
                url: "/Ajax/userAjax.php?action=getLoginInfo",
                type: 'get',
                dataType: 'json',
                success: function (result) {
                    if (result.code == 0) {
                        $.each(result.data, function (i, item) {
                            var day = new Date(item.logintime * 1000);
                            $('#admin-info').append('<tr>' + '<td>' + item.username + '</td>' + '<td>' + day.toLocaleString() + '</td>' + '<td>' + item.loginip + '</td>' + '</tr>');
                        });
                    }
                }
            });

        });
        function changePwd() {
            $('#modal-title').html('修改密码');
            $('#modal-1').show();
            $('#modal-2').hide();
            $('#dialog').trigger('click');
        }
        function administrator() {
            $('#modal-title').html('管理员');
            $('#modal-1').hide();
            $('#modal-2').show();
            $('#dialog').trigger('click');
        }
        <?php if($role['teacher']){?>
        function teacher() {
            $('#modal-title').html('<?php echo $_SESSION["teacher_operator"]."老师";?>');
            $('#modal-1').hide();
            $('#modal-2').show();
            $('#dialog').trigger('click');
        }
        <?php } ?>
        function isNull($str) {
            if ($str == null) {
                return '';
            }
            return $str;
        }
        function tab(i) {
            $('.sub-menu').eq(i).slideToggle();
        }
</script>
</body>
</html>
