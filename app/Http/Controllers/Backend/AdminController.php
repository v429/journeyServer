<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
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
}