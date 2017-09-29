<html>
<head>
    <title>{{$pageTitle}}</title>
    <script src="{{$BaseURL}}/js/jquery.min.js"></script>
    <script src="{{$BaseURL}}/js/common.js"></script>
    <script>
        var base_url = '{{$BaseURL}}/';
    </script>
</head>
<body>
    <form action="" method="post" id="login-form">
        用户名：<input type="text" name="name" /><br />
        密码：<input type="password" name="password"><br />
        <input type="button" value="登录" id="Js_submit_login">
    </form>
<script>
    $('#Js_submit_login').on('click', function()
    {
        var url = base_url + 'backend/login';
        var data = $('#login-form').serialize();
        $.ajax({
            type:'POST',
            url:url,
            data:data,
            dataType:'json',
            success:function(data){
                if (data.errCode == 0)
                {
                    alert('登录成功');
                    window.location.href = base_url + 'backend/active/list';
                }
            }
        });
    });

</script>
</body>
</html>