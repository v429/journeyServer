/**
 * Created by weitian on 14-11-30.
 */
//日期选择控件初始化
$('.selectDate').datepicker();

//设置任务
$('.Js_add_duty_ok').click(function() {
    var data = $('#form-add-duty').serialize();
    var url = 'duty/add-duty';
    ajax(url, data, function(data) {
        if (data.status == 'ok') {
            alert('添加成功');
            window.location.href = base_url + 'duty/duty-list';
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        } else {
            checkError(data.message);
        }
    })
});

//查询指定日期的任务
$('.Js_select_dutys_time').click(function() {
    var time = $('.Js_duty_list_time').val();
    window.location.href = base_url + 'duty/duty-list/1/' + time;
});

//修改任务
$('.Js_update_duty_ok').click(function() {
    var data = $('#form-update-duty').serialize();
    var url = 'duty/update-duty';
    ajax(url, data, function(data) {
        if (data.status == 'ok') {
            alert('修改成功');
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        } else {
            checkError(data.message);
        }
    })
});

//删除任务
$('.Js_delete_duty').click(function() {
    var id = $(this).attr('data');
    if(confirm("确定要删除该任务吗,删除后无法数据将恢复！")){
        var url = 'duty/delete-duty';
        ajax(url, {id:id}, function(data) {
            if (data.status == 'ok') {
                alert('删除成功');
                window.location.reload();
            } else if (data.status == 10001) {
                window.location.href = 'base_url' + 'user/login';
            } else {
                checkError(data.message);
                window.location.refresh();
            }
        })
    }
});

//个人任务方式查询
$('.Js_duty_type').change(function() {
    var type = $(this).val();

    window.location.href = base_url + 'duty/my-duty-list/' + type;
})
