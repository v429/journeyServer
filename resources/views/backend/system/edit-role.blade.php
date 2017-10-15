@extends('backend.framework')
@section('title')
    编辑角色
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
                    <h5>编辑角色</h5>

                </header>
                <div id="collapse2" class="body">
                    <form class="form-horizontal" id="form-edit-role">
                        <div class="form-group">
                            <label class="control-label col-lg-4">角色名</label>
                            <div class="col-lg-4">
                                <input type="text" class="validate[required] form-control" name="name" id="req" value="{{$role->title}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">权限选择</label>
                            <div class="col-lg-4">
                                @foreach($authTree as $key => $auth)
                                    <input type="checkbox" name="auth_ids[]" value="{{$auth['id']}}" class=""
                                    @if (in_array($auth['id'], $auths))
                                        checked
                                    @endif
                                    >{{$auth['title']}}<br>
                                    @foreach($auth['childs'] as $key => $child)
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="auth_ids[]" value="{{$child['id']}}"
                                       @if (in_array($child['id'], $auths))
                                            checked
                                       @endif
                                        >{{$child['title']}}<br>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" value="{{$role->id}}" name="id" />
                        <div class="form-actions no-margin-bottom" style="text-align:center">
                            <input type="button" value="修改" class="btn btn-primary Js_edit_role_ok" style="width:200px;margin:auto">
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div>
    <script language="javascript">
        //添加角色
        $('.Js_edit_role_ok').on('click', function() {
            var data = $('#form-edit-role').serialize();
            var url = 'backend/role/update';
            ajax(url, data, function(data) {
                if (data.errCode == '0') {
                    alert('修改成功');
                    window.location.href = base_url + 'backend/role/list';
                } else if(data.errCode == '500') {
                    checkError(data.content);
                } else {
                    alert('未知错误');
                }
            })
        });

    </script>
@stop