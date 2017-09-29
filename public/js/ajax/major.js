//添加专业-二级专业联动
$('.Js_major_type_select').change(function() {
    var v = $(this).val();
    if(v == '1') {
        $('.Js_major_parent_choose').show();
    } else {
        $('.Js_major_parent_choose').hide();
    }
});

//添加专业
$('.Js_add_major_ok').click(function() {
    var data = $('#form-add-major').serialize();
    var url  = 'major/add-major';

    ajax(url, data, function(data) {
        if (data.status == 'ok') {
            alert('添加成功');
            window.location.href = base_url + 'home/majors';
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        } else {
            checkError(data.message);
        }
    });
});

//修改专业
$('.Js_update_major_ok').live('click', function() {
        var url = 'major/update-major';
        var data = $('#form-update-major').serialize();

        ajax(url, data, function(data) {
            if (data.status == 'ok') {
                alert('修改成功');
                window.location.href = base_url + 'home/majors';
            } else if (data.status == 10001) {
                window.location.href = base_url + 'user/login';
            } else {
                checkError(data.message);
            }
        });
});

//删除专业
$('.Js_delete_major_ok').live('click', function() {
    if (confirm("确认删除？删除后数据无法恢复;输机计划开始后建议不要删除专业！否则可能会造成数据出错"))  {
        var id = $(this).attr('data-id');
        var url = 'major/delete-major';
        var data ={id:id};

        ajax(url, data, function(data){
            if (data.status == 'ok') {
                alert('删除成功');
                window.location.reload();
            } else if (data.status == 10001) {
                window.location.href = base_url + 'user/login';
            } else {
                checkError(data.message);
            }
        });
    }
});/**
 * Created by v429 on 15-3-5.
 */
