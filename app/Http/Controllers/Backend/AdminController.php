<?php

namespace App\Http\Controllers\Backend;

use App\Common\Utils;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Services\rbacService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Request;



class AdminController extends Controller
{

    /**
     * 登录页面
     *
     * @return mixed
     */
    public function login()
    {
        $this->pageTitle = '登录';

        return $this->display('backend/admin/login');
    }

    /**
     * 登录接口
     *
     * @param Request $request
     * @return mixed
     */
    public function doLogin(Request $request)
    {
        $name     = $request->get('name');
        $password = $request->get('password');

        if (!$name || !$password)
        {
            $this->errorOut('请输入用户名密码');
        }

        $admin = AdminService::login($name, $password);
        if ($admin)
        {
            $cookie = Cookie::make('admin_id', $admin->id);

            return Response::make(['errCode' => 0, 'errMsg' => '', 'content' => 'ok'])->withCookie($cookie);
        }

        $this->errorOut('登录失败，用户名密码错误', 'error login fail');
    }

    /**
     * 管理员列表页
     *
     * @return mixed
     */
    public function adminList()
    {
        $list = AdminService::getList(0, env('BACKEND_ITEM_PERPAGE'));

        $this->data['list'] = $list;
        $this->data['pageTitle'] = '管理员列表';
        return $this->display('backend.admin.list');
    }

    /**
     * 添加管理员页面
     *
     * @return mixed
     */
    public function add()
    {
        $roles = rbacService::getAllRole();

        $this->data['roles'] = $roles;
        $this->pageTitle = '添加管理员';
        return $this->display('backend.admin.add');
    }

    /**
     * 添加管理员接口
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        $name          = $request->get('name');
        $password      = $request->get('password');
        $passwordAgain = $request->get('passwordAgain');
        $email         = $request->get('email');
        $roleId        = $request->get('role_id');

        if ($password != $passwordAgain)
        {
            $this->errorOut(['两次密码输入不一样'], '两次密码输入不一样');
        }
        //用户名已存在
        if (AdminService::checkExist($name))
        {
            $this->errorOut(['用户名已存在', 'error user name exist']);
        }

        AdminService::addAdmin($name, $password, $email, $roleId);

        Utils::infoLog('add admin:' . $name . ' success', compact('name', 'password', 'email', 'roleId'));
        $this->successOut('添加成功');
    }
}