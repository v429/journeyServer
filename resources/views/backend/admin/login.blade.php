<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script language="javascript" src="{{$BaseURL}}/js/jquery.min.js"></script>
    <script language="javascript" src="{{$BaseURL}}/js/boot/bootstrap.js"></script>
    <script language="javascript" src="{{$BaseURL}}/js/boot/bootstrap.min.js"></script>
    <script language="javascript" src="{{$BaseURL}}/js/common.js"></script>
    <script language="javascript" src="{{$BaseURL}}/js/ajax/login.js"></script>
    <script language="javascript">
        var base_url = '{{$BaseURL}}/';
    </script>

    <link rel="stylesheet" type="text/css" href="{{$BaseURL}}/css/boot/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{$BaseURL}}/css/boot/bootstrap.css.map">
    <link rel="stylesheet" type="text/css" href="{{$BaseURL}}/css/boot/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{$BaseURL}}/css/boot/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="{{$BaseURL}}/css/boot/bootstrap-theme.css.map">
    <link rel="stylesheet" type="text/css" href="{{$BaseURL}}/css/boot/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="{{$BaseURL}}/css/login.css" />
    <title>{{$pageTitle}}</title>
</head>
<body>
<div class="container">
    <section class="loginBox row-fluid">
        <section class="span7 left">
            <h2>用户登录</h2>
            <p>登录名<input type="text" name="name" class="Js_login_name" /></p>
            <p>密　码<input type="password" name="password" class="Js_login_password" /></p>

            <section class="row-fluid login-bottom">
                <section class="span1"><input type="button" value="登录" class="btn btn-primary Js_login_ok"></section>
            </section>
        </section>
    </section><!-- /loginBox -->
</div> <!-- /container -->
<script>

    $('.Js_login_ok').on('click', function() {
        var url = 'backend/login';
        var name = $('.Js_login_name').val();
        var password = $('.Js_login_password').val();
        var data = {name:name,password:password};
        ajax(url, data, function(res) {
            if (res.errCode == 0)
            {
                window.location.href = base_url + 'backend/active/list';
            } else if (res.errCode == 500) {
                alert(res.content);
            }
        });
    });

    $(document).keypress(function(e) {
        // 回车键事件
        if(e.which == 13) {
            $('.Js_login_ok').click();
        }
    });
</script>
</body>
</html>