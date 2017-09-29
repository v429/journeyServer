/**
 * Created by weitian on 14-11-27.
 */
/*
$('.Js_province_select').change(function(){
    var province_id = $(this).val();
    var url = 'home/get-city';
    ajax(url, {id:province_id}, function(data) {
       if (data.status == 'ok') {
          var citys = data.content.content;
           var html = '';
           $.each(citys, function(i) {
                html += '<option value="' + this.id + '">' + this.name + '</option>';
           });
           $('.Js_city_select').html('');
           $('.Js_city_select').html(html);
       }
    });
});
*/

//添加学生
$('.Js_add_student_ok').click(function() {
    var data = $('#form-add-student').serialize();
    var url  = 'student/add-student';
    ajax(url, data, function(data) {       
        if (data.status == 'ok') {
            alert('添加成功');
            $('#form-add-student').reset();
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        } else {
            checkError(data.message);
        }
    })
});

//修改学生
$('.Js_update_student_ok').click(function() {
    var data = $('#form-update-student').serialize();
    var url = 'student/update-student';
    ajax(url, data, function(data) {
        if (data.status == 'ok') {
            $('.Js_select_student_index').focus();
            //alert('修改成功');
            window.location.reload();
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        }  else {
            checkError(data.message);
        }
    })
});

//复查学生
$('.Js_check_student_ok').click(function() {
    $('.Js_ischeck_value').val(1);
    var url  = 'student/check-student';
    var id   = $(this).attr('data-id');
    var status = $(this).attr('data-status');
    var data = {id:id,status:status};

    //在详情页点击同时修改学生
    $('.Js_update_student_ok').click();

    ajax(url, data, function(data) {
        if (data.status == 'ok') {
            $('.Js_select_student_index').focus();
            //alert('成功');
            window.location.reload();
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        } else {
            checkError(data.message);
        }
    })
});

//复查通过学生
$('.Js_pass_student_ok').click(function() {
    var obj = $(this);
    if(confirm("确认该生已通过复查？")){
        var url = 'student/check-student';
        var id  = $(this).attr('data-id');
        var status = $(this).attr('data-status');

        ajax(url, {id:id,status:status}, function(data){
            if (data.status == 'ok') {
                $('.Js_select_student_index').focus();
                alert('成功');
                obj.parent('.stu-list-item').html('已完成');
                obj.attr('title', '');
            } else if (data.status == 10001) {
                window.location.href = base_url + 'user/login';
            } else {
                checkError(data.message);
            }
        });
    }
});

$('.Js_delete_student').click(function() {
    var obj = $(this);
    if(confirm("确认删除该生?删除后数据无法恢复")){
        var url = 'student/delete-student';
        var id  = $(this).attr('data-id');

        ajax(url, {id:id}, function(data){
            if (data.status == 'ok') {
                $('.Js_select_student_index').focus();
                alert('删除成功');
                window.location.reload();
            } else if (data.status == 10001) {
                window.location.href = base_url + 'user/login';
            } else {
                checkError(data.message);
            }
        });
    }
});

//学生详情页排名方式变化
$('.Js_rank_change').live('click', function () {
    var id   = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    var data = {id:id, type:type};
    var url  = 'student/student-rank-change';

    ajax(url, data, function(data) {
       if (data.status == 'ok') {
            $('.Js_student_rank').html(data.content.content);

           if (type == 'all') {
               $('.Js_rank_change').attr('data-type', 'city');
               $('.Js_rank_change').val('查看该省排名');
           } else {
               $('.Js_rank_change').attr('data-type', 'all');
               $('.Js_rank_change').val('查看所有省排名');
           }
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        }
    });

});

//导出学生
$('.Js_output_student_ok').click(function() {
    $(this).val('正在导出....');
    var data = $('#form-student-output').serialize();
    var url  = 'student/output-to-exl';

    window.location.href = base_url + url + '?' + data;
});

//添加学生二级专业联动
$('.Js_main_major').change(function () {
    var id = $(this).val();
    var url = 'major/get-sec-major';
    var data = {id:id};
    ajax(url, data, function (data) {
        if (data.status == 'ok') {

            var thtml = '<option value="0">请选择</option>';
            $.each(data.content.content, function(i) {
                thtml += '<option value="' + this.id + '">' + this.name + '</option>';
            });

            $('.Js_sec_major').html(thtml);
            $('.Js_sec_major_span').show();
        } else if (data.status == 10001) {
            window.location.href = base_url + 'user/login';
        }
    });
});