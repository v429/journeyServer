<?php
namespace App\Http\Controllers;

use App\Services\AdminService;
use App\Services\rbacService;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    /**
     * 页面渲染数据
     */
    protected $data;

    /**
     * 页面标题
     */
    protected $pageTitle;

    /**
     * 页面模块
     */
    protected $pageModule = 'backend';

    public function __construct()
    {
        $this->_init();
    }

    /**
     * 控制器初始化
     */
    protected function _init()
    {

    }

    /**
     * 页面渲染
     * @param string $path view路径
     */
    protected function display($path = '', $toString = false)
    {
        //渲染权限目录树
        $this->data['menuTree'] = rbacService::getAuthTreeByAdminId();

        //渲染页面标题
        switch ($this->pageModule)
        {
            case 'backend' : $this->data['pageTitle'] = 'Admin | '. $this->pageTitle;break;
            default : $this->data['pageTitle'] = 'Admin | '. $this->pageTitle;
        }
        //根目录页面变量
        $this->data['BaseURL'] = URL::to('/');

        //获取当前登录用户信息
        $this->data['loginAdminName'] = '';
        $this->data['loginAdminId']   = '';
        $loginInfo = AdminService::getLoginAdminInfo();
        if ($loginInfo)
        {
            $this->data['loginAdminName'] = $loginInfo->name;
            $this->data['loginAdminId']   = $loginInfo->id;
        }

        if ($toString)
            return View::make($path, $this->data)->__toString();

        return View::make($path, $this->data);
    }

    /**
     * 输出json响应
     */
    protected function output($data, $status, $error = '')
    {
        header('content-type:application/json;charset=utf8');
        $result = ['errCode' => $status, 'errMsg' => '', 'content' => $data];
        if ($error)
        {
            $result['errMsg'] = $error;
        }

        echo json_encode($result);exit;
    }

    /**
     * 输出错误json响应
     */
    protected function errorOut($content, $msg = '', $status = 500)
    {
        if (!$msg)
            $msg = $content;

        $this->output($content, $status, $msg);
    }

    /**
     * 输出成功json响应
     */
    protected function successOut($content)
    {
        $this->output($content, 0);
    }

    /**
     * 断点调试
     * @param string $value
     */
    protected function p($value = '')
    {
        echo '<pre>';print_r($value);exit;
    }

}
