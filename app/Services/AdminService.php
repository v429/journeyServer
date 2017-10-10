<?php
namespace App\Services;

use App\Common\Utils;
use App\Models\Admin;

class AdminService extends BaseService
{

    /**
     * 登录
     */
    public static function login($name, $password)
    {
        $admin = Admin::getByNameAndEmail($name);

        if ($admin && $admin->password == self::encryPassword($password))
        {
            //修改最近登录时间
            Admin::updateAdminAttr($admin->id, 'last_login_time', date('Y-m-d H:i:s', time()));

            return $admin;
        }

        return false;
    }

    /**
     * 添加一个管理员
     *
     * @param $name
     * @param $password
     * @param $email
     * @param $roleId
     * @return bool|mixed
     */
    public static function addAdmin($name, $password,$email, $roleId)
    {
        $password = self::encryPassword($password);

        return Admin::addAdmin($name, $password, $email, $roleId);
    }

    /**
     * 修改管理员属性
     *
     * @param $id
     * @param $name
     * @param $email
     * @param $roleId
     * @return bool
     */
    public static function updateAdmin($id, $name, $email, $roleId)
    {
        return Admin::updateAdmin($id, $name, $email, $roleId);
    }

    /**
     * 修改密码
     *
     * @param $id
     * @param $oldPassword
     * @param $newPassword
     * @return bool
     */
    public static function updatePassword($id, $oldPassword, $newPassword)
    {
        $admin = Admin::getAdmin($id);

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
     *
     * @param $password
     * @return string
     */
    public static function encryPassword($password)
    {
        $result = md5($password) . env('APP_KEY');

        return md5($result);
    }
}