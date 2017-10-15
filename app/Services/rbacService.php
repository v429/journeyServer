<?php

namespace App\Services;

use App\Common\Utils;
use App\Models\Admin;
use App\Models\Auth;
use App\Models\Role;
use App\Models\RoleAuth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class rbacService extends BaseService
{
    /**
     * 检查用户权限
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
     * 获取角色详情
     */
    public static function getRole($id)
    {
        $role = Role::getRole($id);
        if (!$role)
        {
            return false;
        }

        $auths = RoleAuth::getAuthList($id);

        return ['role' => $role, 'auths' => $auths];
    }

    /**
     * 获取权限详情
     */
    public static function getAuth($id)
    {
        $auth = Auth::getAuth($id);

        return $auth;
    }

    /**
     * 获取所有角色
     */
    public static function getAllRole()
    {
        $roles = Role::getRoleList(0,-1);

        return $roles;
    }

    /**
     * 获取所有权限树
     */
    public static function getTree()
    {
        return Auth::getTree(true);
    }

    /**
     * 根据管理员ID获取权限菜单树
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
     */
    public static function getAuthUrlList($roleId)
    {
        $authIds = RoleAuth::getAuthList($roleId);

        $urls = Auth::getUrlsFromAuthIdList($authIds);

        return $urls;
    }

    /**
     * 获取角色列表
     */
    public static function getRoleList($start = 0, $limit = 15)
    {
        return Role::getRoleList($start, $limit);
    }

    /**
     * 获取菜单列表
     */
    public static function getAuthList($start = 0, $limit = 15)
    {
        return Auth::getAuthList($start, $limit);
    }

    /**
     * 获取所有一级菜单
     */
    public static function getAllParent()
    {
        return Auth::getByType(Auth::AUTH_TYPE_FIRST, false);
    }

    /**
     * 添加角色
     */
    public static function addRole($name, $authIds)
    {
        $roleId = Role::createRole($name);

        if (!$roleId)
        {
            return false;
        }

        if(RoleAuth::createRoleAuths($roleId, $authIds))
            return $roleId;

        return false;
    }

    /**
     * 修改角色
     */
    public static function updateRole($id, $name, $authIds)
    {
        if (Role::updateRole($id, $name))
        {
            if(RoleAuth::updateRoleAuth($id, $authIds))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * 添加一个权限
     */
    public static function addAuth($title, $url, $isMenu, $type, $parentId, $sort)
    {
        return Auth::createAuth($title, $url, $isMenu, $type, $parentId, $sort);
    }

    /**
     * 修改权限
     */
    public static function updateAuth($id, $title, $url, $isMenu, $type, $parentId, $sort)
    {
        return Auth::updateAuth($id, $title, $url, $isMenu, $type, $parentId, $sort);
    }

    /**
     * 删除权限
     */
    public static function deleteAuth($id)
    {
        DB::beginTransaction();
        if (Auth::deleteAuth($id))
        {
            if (RoleAuth::deleteRoleAuthByAuth($id)) {
                DB::commit();
                return true;
            }
            DB::rollback();
            return false;
        }

        Utils::errorLog('error delete auth error,maybe auth:'.$id.' not exist');
        return false;
    }

    /**
     * 根据ID判断用户是否为root
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
            $root->status = Admin::ADMIN_STATUS_ENABLE;

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