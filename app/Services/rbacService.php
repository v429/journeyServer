<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Auth;
use App\Models\Role;
use App\Models\RoleAuth;
use Illuminate\Support\Facades\Cookie;

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
     * 获取所有角色
     *
     * @return mixed
     */
    public static function getAllRole()
    {
        $roles = Role::getRoleList(0,-1);

        return $roles;
    }

    /**
     * 根据管理员ID获取权限菜单树
     *
     * @param int $adminId
     * @return array
     */
    public static function getAuthTreeByAdminId($adminId = 0)
    {
        $tree = Auth::getTree();

        if (!$adminId)
            $adminId = Cookie::get('admin_id');

        if ($adminId)
        {
            $admin   = Admin::getAdmin($adminId);
            if (!$admin)
                return false;

            //ROOT拥有所有权限
            if (self::isRoot($adminId))
            {
                return $tree;
            }
            //获取该用户所拥有的权限树IDS
            $authIds = RoleAuth::getAuthList($admin->role_id);
            foreach ($tree as $key => $parent)
            {
                if (!in_array($parent['id'], $authIds))
                {
                    unset($tree[$key]);
                    continue;
                }

                foreach($parent['childs'] as $k => $child)
                {
                    if (!in_array($child['id'], $authIds))
                    {
                        unset($tree[$key]['childs'][$k]);
                    }
                }
            }
            return $tree;
        }
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
            return true;

        unset($admin);
        return false;
    }


    /**
     * 初始化root用户
     */
    public static function initRootUser()
    {
        $isExist = Admin::getByNameAndEmail('root');
        if (!$isExist)
        {
            //创建root用户
            $root = new Admin();
            $root->name     = 'root';
            $root->password = AdminService::encryPassword(env('ROOT_PASSWORD'));
            $root->email    = 'v429god@163.com';
            $root->role_id  = 1;
            $root->last_login_time = date('Y-m-d H:i:s', time());

            $root->save();

            //创建一个管理员角色
            Role::createRole('系统管理员');
        }
    }

    /**
     * 初始化基本菜单
     */
    public static function initAuths()
    {
        foreach (Auth::$initAuths as $auth)
        {
            Auth::createAuth($auth['title'], $auth['url'], $auth['is_menu'], $auth['type'], $auth['parent_id']);
        }
    }

}