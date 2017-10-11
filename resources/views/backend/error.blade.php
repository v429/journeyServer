@extends('backend.framework')
@section('content')
    <div style="text-align: center; color:red; font-size:14px; height:500px; padding-top:200px">
        <p style="text-align: center">{{$errMsg}}</p>
        <p>3秒后跳转页面，如果等不及<a id="goJump">点击这里</a></p>
    </div>
    <script>
        var jumpUrl = '{{$jump}}';

        $("#goJump").on("click", jump);

        setTimeout(jump, 3000);

        function jump() {
            if (jumpUrl) {
                window.location.href = base_url + jumpUrl;
            } else {
                history.go(-1);
            }
        }

    </script>


@stop