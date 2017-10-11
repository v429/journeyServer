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
                    <h5>编辑管理员：{{$admin->name}}</h5>

                </header>
                <div id="collapse2" class="body">
                    <form class="form-horizontal" id="form-update-admin">
                        <div class="form-group">
                            <label class="control-label col-lg-4">用户名</label>
                            <div class="col-lg-4">
                                <input type="text" class="validate[required] form-control" name="name" id="req" value="{{$admin->name}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-4">邮箱</label>
                            <div class=" col-lg-4">
                                <input class="form-control" type="text" name="email" id="email" value="{{$admin->email}}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">角色选择</label>
                            <div class="col-lg-4">
                                <select name="role_id" class="form-control">
                                    @foreach($roles as $key => $role)
                                        <option value="{{$role->id}}" @if($admin->role_id == $role->id) selected @endif>{{$role->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" value="{{$admin->id}}" name="id" />
                        <div class="form-actions no-margin-bottom" style="text-align:center">
                            <input type="button" value="修改" class="btn btn-primary Js_edit_admin_ok" style="width:200px;margin:auto">
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div>
    <script language="javascript">
        //修改用户
        $('.Js_edit_admin_ok').on('click', function() {
            var data = $('#form-update-admin').serialize();
            var url = 'backend/admin/update';
            ajax(url, data, function(data) {
                if (data.errCode == '0') {
                    alert('修改成功');
                    window.location.href = base_url + 'backend/admin/list';
                } else if(data.errCode == '500') {
                    checkError(data.content);
                } else {
                    alert('未知错误');
                }
            })
        });

    </script>
@stop