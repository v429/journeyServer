<?php
namespace App\Services;

use App\Common\Utils;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Cookie;

class AdminService extends BaseService
{

    /**
     * 根据ID获取ADMIN
     */
    public static function getAdmin($id)
    {
        $admin = Admin::getAdmin($id);
        if (!$admin)
        {
            Utils::errorLog('admin not found!id: ' . $id);
            return false;
        }

        return $admin;
    }

    /**
     * 获取当前登录管理员信息
     */
    public static function getLoginAdminInfo()
    {
        $loginId = Cookie::get('admin_id');

        if ($loginId)
        {
            $admin = Admin::getAdmin($loginId);

            return $admin;
        }
        return false;
    }

    /**
     * 获取管理员列表
     */
    public static function getList($start = 0, $limit = 15)
    {
        $list = Admin::getAdminList($start, $limit);

        foreach ($list as $key => $admin)
        {
            $list[$key]->role_name = '';
            //组装管理员角色名
            $role = Role::getRole($admin->role_id);
            if ($role)
            {
                $list[$key]->role_name = $role->title;
            }
        }

        return $list;
    }

    /**
     * 登录
     */
    public static function login($name, $password)
    {
        $admin = Admin::getByNameAndEmail($name);

        if ($admin && $admin->password == self::encryPassword($password) && $admin->status == Admin::ADMIN_STATUS_ENABLE)
        {
            //修改最近登录时间
            Admin::updateAdminAttr($admin->id, 'last_login_time', date('Y-m-d H:i:s', time()));

            return $admin;
        }

        return false;
    }

    /**
     * 检查该用户是否存在
     */
    public static function checkExist($name, $id = 0)
    {
        $admin = Admin::where('name', $name)->first();

        if ($admin && $id && $admin->id == $id) {
            return false;
        }

        return $admin ? true : false;
    }

    /**
     * 添加一个管理员
     */
    public static function addAdmin($name, $password,$email, $roleId)
    {
        //用户已存在
        if (self::checkExist($name))
        {
            Utils::errorLog('add user :' . $name . ' already exist!');
            return false;
        }

        $password = self::encryPassword($password);

        return Admin::addAdmin($name, $password, $email, $roleId);
    }

    /**
     * 修改管理员属性
     */
    public static function updateAdmin($id, $name, $email, $roleId)
    {
        return Admin::updateAdmin($id, $name, $email, $roleId);
    }

    /**
     * 修改密码
     */
    public static function updatePassword($id, $oldPassword, $newPassword)
    {
        $admin = Admin::getAdmin($id);
        //验证原密码
        if ($admin->password == self::encryPassword($oldPassword))
        {
            if (Admin::updateAdminAttr($id, 'password', self::encryPassword($newPassword)))
                return true;
        }

        Utils::errorLog('update user :' . $id . ' password error, old password wrong!');
        return false;
    }

    /**
     * 密码加密
     */
    public static function encryPassword($password)
    {
        $result = md5($password) . env('APP_KEY');

        return md5($result);
    }

    /**
     * 停用/启用管理员
     */
    public static function stopOrStartAdmin($id)
    {
        $admin = self::getAdmin($id);

        if ($admin)
        {
            //停用
            if ($admin->status == Admin::ADMIN_STATUS_ENABLE)
            {
                Admin::updateAdminAttr($id, 'status', Admin::ADMIN_STATUS_STOP);
                return true;
            }
            //启用
            Admin::updateAdminAttr($id, 'status', Admin::ADMIN_STATUS_ENABLE);
            return true;
        }
        //管理员不存在
        Utils::errorLog('admin not found in stopOrStartAdmin');
        return false;
    }
}