@extends('backend.framework')
@section('title')
    管理员列表
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header>
                    <div class="icons">
                        <i class="fa fa-table"></i>
                    </div>
                    <h5>管理员列表</h5>
                </header>
                <div id="collapse4" class="body">
                    <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                        <tr>
                            <th>登录名</th>
                            <th>email</th>
                            <th>最近登录时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $admin)
                            <tr>
                                <td>{{$admin->name}}</td>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->last_login_time}}</td>
                                <td><a href="{{$BaseURL}}/backend/admin/edit?id={{$admin->id}}">编辑</a> |
                                    <a href="javascript:;" class="Js_change_admin_status" data="{{$admin->id}}">
                                        @if ($admin->status == \App\Models\Admin::ADMIN_STATUS_ENABLE)
                                            停用
                                        @else
                                            启用
                                        @endif
                                    </a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-xs-6">
                        <div id="dataTable_paginate" class="dataTables_paginate paging_simple_numbers" style="float: right">{{$list->render()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script language="javascript">
        $('.Js_change_admin_status').on('click', function() {
            var url = 'backend/admin/change-status';
            var id = $(this).attr('data');
            var data = {id:id};

            ajax(url, data, function(res) {
                if (res.errCode == 0){
                    alert('操作成功');
                    window.location.href = base_url + 'backend/admin/list';
                } else {
                    alert(res.errMsg);
                }
            });
        });

    </script>
@stop