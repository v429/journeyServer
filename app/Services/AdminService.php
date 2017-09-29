<?php
namespace App\Services;

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
            return $admin;
        }

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