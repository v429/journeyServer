//添加用户
$('.Js_add_admin_ok').on('click', function() {
    var data = $('#form-add-admin').serialize();
    var url = 'backend/admin/create';
    ajax(url, data, function(data) {
        if (data.errCode == '0') {
            alert('添加成功');
            window.location.href = base_url + 'backend/admin/list';
        } else {
            alert('添加失败')
        }
    })
});

//修改用户
$('.Js_update_user_ok').click(function() {
    var data = $('#form-update-user').serialize();
    var url = 'user/update-user';
    ajax(url, data, function(data) {
        if (data.status == 'ok') {
            alert('修改成功');
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        } else {
            checkError(data.message);
            window.location.refresh();
        }
    })
});

//修改用户密码
$('.Js_update_password_ok').click(function() {
    var data = $('#form-update-password').serialize();
    var url = 'user/update-password';
    ajax(url, data, function(data) {
        if (data.status == 'ok') {
            alert('修改成功');
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        } else {
            checkError(data.message);
            window.location.refresh();
        }
    })
});

//删除用户
$('.Js_delete_user').click(function() {
    var id = $(this).attr('data');
    if(confirm("确定要删除该用户吗,删除后无法数据将恢复！")){
        var url = 'user/delete-user';
        ajax(url, {id:id}, function(data) {
            if (data.status == 'ok') {
                alert('删除成功');
                window.location.reload();
            } else if (data.status == 10001) {
                window.location.href = base_url + 'user/login';
            } else {
                checkError(data.message);
                window.location.refresh();
            }
        })
    }
});