@extends('backend.framework')
@section('title')
    角色列表
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <header>
                    <div class="icons">
                        <i class="fa fa-table"></i>
                    </div>
                    <h5>角色列表</h5>
                </header>
                <div id="collapse4" class="body">
                    <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                        <tr>
                            <th>角色</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{$role->title}}</td>
                                <td>
                                     <a href="{{$BaseURL}}/backend/role/edit?id={{$role->id}}">编辑</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-xs-6">
                        <div id="dataTable_paginate" class="dataTables_paginate paging_simple_numbers" style="float: right">{{$roles->render()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script language="javascript">
/*        $('.Js_change_admin_status').on('click', function() {
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
        });*/

    </script>
@stop