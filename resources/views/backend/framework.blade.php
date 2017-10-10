<!doctype html>
<html class="no-js">
<head>
    <meta charset="UTF-8">
    <title>{{$pageTitle}}</title>

    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{$BaseURL}}/lib/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{$BaseURL}}/lib/font-awesome/css/font-awesome.min.css">

    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="{{$BaseURL}}/css/main.min.css">
    <link rel="stylesheet" href="{{$BaseURL}}/css/style.css">
    <link rel="stylesheet" href="{{$BaseURL}}/css/jquery-ui.min.css">
    <!-- Metis Theme stylesheet -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
    <script src="{{$BaseURL}}/lib/html5shiv/html5shiv.js"></script>
    <script src="{{$BaseURL}}/lib/respond/respond.min.js"></script>
    <![endif]-->

    <!--For Development Only. Not required -->
    <script>
        less = {
            env: "development",
            relativeUrls: false,
            rootpath: "../{{$BaseURL}}/"
        };

    </script>
    <link rel="stylesheet" href="{{$BaseURL}}/css/style-switcher.css">
    <link rel="stylesheet/less" type="text/css" href="{{$BaseURL}}/css/less/theme.less">
    <script src="{{$BaseURL}}/lib/less/less-1.7.3.min.js"></script>

    <!--Modernizr 2.8.2-->
    <script src="{{$BaseURL}}/lib/modernizr/modernizr.min.js"></script>
    <script language="javascript">
        var base_url = '{{$BaseURL}}/';
    </script>
    <script language="javascript" src="{{$BaseURL}}/js/jquery.js"></script>
    <script language="javascript" src="{{$BaseURL}}/js/common.js"></script>
    <script>

        document.onkeydown = function(e){
            var ev = document.all ? window.event : e;
            if(ev.keyCode==13) {

            }
        }


    </script>
    <script language="javascript" src="{{$BaseURL}}/js/boot/bootstrap.js"></script>
    <script language="javascript" src="{{$BaseURL}}/js/boot/bootstrap.min.js"></script>
    <script language="javascript" src="{{$BaseURL}}/js/jquery-ui.min.js"></script>

    <script language="javascript" src="{{$BaseURL}}/js/ajax/common.js"></script>

</head>
<body class="  ">
<div class="bg-dark dk" id="wrap">
    <div id="top">

        <!-- .navbar -->
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container-fluid">

                <!-- Brand and toggle get grouped for better mobile display -->
                <header class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="{{$BaseURL}}/user/index" class="navbar-brand" style="font-family: 'Microsoft YaHei', sans-serif;line-height: 50px; font-size: 24px; font-weight: bold; padding-left: 60px;">
                    </a>
                    <span style="line-height:50px; color:#666666; margin-left:50px;">欢迎：管理员{{$loginAdminName}}</span>
                </header>
                <div class="topnav">
                    <div class="btn-group">
                        <a href="{{$BaseURL}}/admin/logout" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm Js_logout">
                            <i class="fa fa-power-off"></i>
                            登出
                        </a>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </nav><!-- /.navbar -->
        <header class="head">
            <div class="search-bar">
                <input type="text" class="form-control Js_select_student_index" placeholder="" style="font-family: 'Microsoft YaHei', sans-serif">
            </div><!-- /.search-bar -->
            <div class="main-bar">
                <h3>@section('subTitle') @show
                    <i class="fa fa-home"></i></h3>
            </div><!-- /.main-bar -->
        </header><!-- /.head -->
    </div><!-- /#top -->
    <div id="left">


        <!-- #menu -->
        <ul id="menu" class="bg-blue dker">
            <li class="nav-header">菜单</li>
            <li class="nav-divider"></li>
            <li class="">
                <a href="{{$BaseURL}}/user/index">
                    <i class="fa fa-dashboard"></i><span class="link-title">&nbsp;系统首页</span>
                </a>
            </li>
            @foreach ($menuTree as $menu)
            <li class="">
                <a href="javascript:;">
                    <i class="fa fa-building "></i>
                    <span class="link-title">{{$menu['title']}}</span>
                    <span class="fa arrow"></span>
                </a>
                <ul>
                    @foreach ($menu['childs'] as $child)
                    <li>
                        <a href="{{$BaseURL}}/{{$child['url']}}">
                            <i class="fa fa-angle-right"></i>&nbsp; {{$child['title']}}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach

            <li>
                <div style="height:500px;width: 10px;"></div>
            </li>
        </ul><!-- /#menu -->
    </div><!-- /#left -->
    <div id="content">
        <div class="outer">
            <div class="inner bg-light lter">
                @section('content')
                @show
            </div><!-- /.inner -->
        </div><!-- /.outer -->
    </div><!-- /#content -->
    <footer class="Footer bg-dark dker">
        <p>2017 &copy; journey &nbsp;&nbsp;&nbsp;版本：{{env('BASE_VERSION')}}</p>
    </footer><!-- /#footer -->

    <!-- #helpModal -->
    <div id="helpModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                        in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><!-- /#helpModal -->

    <!--jQuery 2.1.1 -->
    <script src="{{$BaseURL}}/lib/jquery/jquery.min.js"></script>

    <!--Bootstrap -->
    <script src="{{$BaseURL}}/lib/bootstrap/js/bootstrap.min.js"></script>

    <!-- Screenfull -->
    <script src="{{$BaseURL}}/lib/screenfull/screenfull.js"></script>

    <!-- Metis core scripts -->
    <script src="{{$BaseURL}}/js/core.js"></script>

    <!-- Metis demo scripts -->
    <script src="{{$BaseURL}}/js/app.min.js"></script>
    <script src="{{$BaseURL}}/js/style-switcher.js"></script>
</body>
</html>