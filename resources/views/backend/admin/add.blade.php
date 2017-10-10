@extends('backend.framework')
@section('title')
    添加管理员
@stop
@section('content')
    <style>
        .form-control.col-lg-6 {
            width: 50% !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header class="dark">
                    <div class="icons">
                        <i class="fa fa-check"></i>
                    </div>
                    <h5>添加管理员</h5>

                </header>
                <div id="collapse2" class="body">
                    <form class="form-horizontal" id="form-add-admin">
                        <div class="form-group">
                            <label class="control-label col-lg-4">用户名</label>
                            <div class="col-lg-4">
                                <input type="text" class="validate[required] form-control" name="name" id="req" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4">密码</label>
                            <div class=" col-lg-4">
                                <input class="form-control" type="password" name="password" id="password" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">确认密码</label>
                            <div class=" col-lg-4">
                                <input class="form-control" type="password" name="passwordAgain" id="passwordAgain" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">邮箱</label>
                            <div class=" col-lg-4">
                                <input class="form-control" type="text" name="email" id="email" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">角色选择</label>
                            <div class="col-lg-4">
                                    <select name="role_id" class="form-control">
                                    @foreach($roles as $key => $role)
                                        <option value="{{$role->id}}">{{$role->title}}</option>
                                    @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="form-actions no-margin-bottom" style="text-align:center">
                            <input type="button" value="添加" class="btn btn-primary Js_add_admin_ok" style="width:200px;margin:auto">
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div>
    <script language="javascript" src="{{$BaseURL}}/js/ajax/admin.js"></script>
@stop