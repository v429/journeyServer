@extends('backend.framework')
@section('title')
    添加菜单
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
                    <h5>添加菜单</h5>

                </header>
                <div id="collapse2" class="body">
                    <form class="form-horizontal" id="form-add-auth">
                        <div class="form-group">
                            <label class="control-label col-lg-4">菜单名</label>
                            <div class="col-lg-4">
                                <input type="text" class="validate[required] form-control" name="title" id="req" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">访问地址</label>
                            <div class="col-lg-4">
                                <input type="text" class="validate[required] form-control" name="url" id="req" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">菜单排序</label>
                            <div class="col-lg-4">
                                <input type="text" class="validate[required] form-control" name="sort" id="req" value="999">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">是否显示为菜单</label>
                            <div class="col-lg-4">
                                <input type="radio" name="is_menu" value="1" checked>是
                                <input type="radio" name="is_menu" value="0">否
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">菜单登记</label>
                            <div class="col-lg-4">
                                <input class="Js_type_one" type="radio" name="type" value="1" checked>一级菜单
                                <input class="Js_type_sec" type="radio" name="type" value="2">二级菜单
                            </div>
                        </div>
                        <div class="form-group Js_parent_div" style="display: none">
                            <label class="control-label col-lg-4">父级菜单</label>
                            <div class="col-lg-4">
                                <select name="parent_id" class="form-control">
                                    <option value="0">无</option>
                                    @foreach($parents as $parent)
                                        <option value="{{$parent->id}}">{{$parent->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-actions no-margin-bottom" style="text-align:center">
                            <input type="button" value="添加" class="btn btn-primary Js_add_auth_ok" style="width:200px;margin:auto">
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-lg-12 -->
    </div>
    <script language="javascript">
        //添加角色
        $('.Js_add_auth_ok').on('click', function() {
            var data = $('#form-add-auth').serialize();
            var url = 'backend/auth/create';
            ajax(url, data, function(data) {
                if (data.errCode == '0') {
                    alert('添加成功');
                    window.location.href = base_url + 'backend/auth/list';
                } else if(data.errCode == '500') {
                    checkError(data.content);
                } else {
                    alert('未知错误');
                }
            })
        });

        $('.Js_type_one').on('change', function()
        {
           $('.Js_parent_div').hide();
        });

        $('.Js_type_sec').on('change', function()
        {
           $('.Js_parent_div').show();
        });

    </script>
@stop