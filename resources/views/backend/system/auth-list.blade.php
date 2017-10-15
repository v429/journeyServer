@extends('backend.framework')
@section('title')
    菜单列表
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header>
                    <div class="icons">
                        <i class="fa fa-table"></i>
                    </div>
                    <h5>菜单列表</h5>
                </header>
                <div id="collapse4" class="body">
                    <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                        <tr>
                            <th>菜单名</th>
                            <th>菜单地址</th>
                            <th>是否是菜单</th>
                            <th>父级菜单</th>
                            <th>菜单类型</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($auths as $auth)
                            <tr>
                                <td>{{$auth->title}}</td>
                                <td>{{$auth->url}}</td>
                                <td>@if($auth->is_menu) 是 @else 否 @endif</td>
                                <td>{{$auth->parent_name}}</td>
                                <td>{{$auth->type_name}}</td>
                                <td>
                                    <a href="{{$BaseURL}}/backend/auth/edit?id={{$auth->id}}">编辑</a> |
                                    <a href="javascript:;" class="Js_delete_auth" data-id="{{$auth->id}}">删除</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-xs-6">
                        <div id="dataTable_paginate" class="dataTables_paginate paging_simple_numbers" style="float: right">{{$auths->render()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script language="javascript">
        $('.Js_delete_auth').on('click', function()
        {
            var id = $(this).attr('data-id');
            var data = {id:id};
            var url = 'backend/auth/del';
            ajax(url, data, function(data)
            {
                if (data.errCode == '0') {
                    alert('删除成功');
                    window.location.href = base_url + 'backend/auth/list';
                } else if(data.errCode == '500') {
                    checkError(data.content);
                } else {
                    alert('未知错误');
                }
            });
        });

    </script>
@stop