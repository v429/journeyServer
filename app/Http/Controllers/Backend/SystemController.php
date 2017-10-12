<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\rbacService;

class SystemController extends Controller
{

    /**
     * 角色列表页面
     */
    public function roleList()
    {
        $roles = rbacService::getRoleList();

        $this->data['roles'] = $roles;
        $this->pageTitle = '角色列表';

        return $this->display('backend.system.role-list');
    }



}