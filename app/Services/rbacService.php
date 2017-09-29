<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Auth;
use App\Models\RoleAuth;

class rbacService extends BaseService
{
    /**
     * 检查用户权限
     *
     * @param $url
     * @param $adminId
     * @return bool
     */
    public static function check($url, $adminId)
    {
        if (self::isRoot($adminId))
        {
            return true;
        }

        $admin = Admin::getAdmin($adminId);

        $urls = self::getAuthUrlList($admin->role_id);

        return in_array(strtolower($url), $urls) ? true : false;
    }

    /**
     * 根据角色ID获取角色url权限列表
     *
     * @param $roleId
     * @return array
     */
    public static function getAuthUrlList($roleId)
    {
        $authIds = RoleAuth::getAuthList($roleId);

        $urls = Auth::getUrlsFromAuthIdList($authIds);

        return $urls;
    }

    /**
     * 根据ID判断用户是否为root
     *
     * @param $adminId
     * @return bool
     */
    public static function isRoot($adminId)
    {
        $admin = Admin::getAdmin($adminId);

        if ($admin->name == 'root')
        {
            return true;
        }

        unset($admin);
        return false;
    }


}