@extends('backend.framework')
@section('title')
    编辑菜单:{{$auth->title}}
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
                    <h5>编辑菜单:{{$auth->title}}</h5>

                </header>
                <div id="collapse2" class="body">
                    <form class="form-horizontal" id="form-add-auth">
                        <div class="form-group">
                            <label class="control-label col-lg-4">菜单名</label>
                            <div class="col-lg-4">
                                <input type="text" class="validate[required] form-control" name="title" id="req" value="{{$auth->title}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">访问地址</label>
                            <div class="col-lg-4">
                                <input type="text" class="validate[required] form-control" name="url" id="req" value="{{$auth->url}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">菜单排序</label>
                            <div class="col-lg-4">
                                <input type="text" class="validate[required] form-control" name="sort" id="req" value="{{$auth->sort}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">是否显示为菜单</label>
                            <div class="col-lg-4">
                                <input type="radio" name="is_menu" value="1" @if($auth->is_menu) checked @endif>是
                                <input type="radio" name="is_menu" value="0" @if(!$auth->is_menu) checked @endif>否
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-4">菜单登记</label>
                            <div class="col-lg-4">
                                <input class="Js_type_one" type="radio" name="type" value="1" @if($auth->type == 1) checked @endif>一级菜单
                                <input class="Js_type_sec" type="radio" name="type" value="2" @if($auth->type == 2) checked @endif>二级菜单
                            </div>
                        </div>
                        <div class="form-group Js_parent_div" @if($auth->type == 1)style="display: none" @endif>
                            <label class="control-label col-lg-4">父级菜单</label>
                            <div class="col-lg-4">
                                <select name="parent_id" class="form-control">
                                    <option value="0" @if(!$auth->parent_id) selected @endif>无</option>
                                    @foreach($parents as $parent)
                                        <option value="{{$parent->id}}" @if($auth->parent_id == $parent->id) selected @endif>
                                            {{$parent->title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" value="{{$auth->id}}" name="id">
                        <div class="form-actions no-margin-bottom" style="text-align:center">
                            <input type="button" value="编辑" class="btn btn-primary Js_add_auth_ok" style="width:200px;margin:auto">
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
            var url = 'backend/auth/update';
            ajax(url, data, function(data) {
                if (data.errCode == '0') {
                    alert('编辑成功');
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