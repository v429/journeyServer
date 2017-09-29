<?php

namespace App\Models;

class RoleAuth extends BaseModel
{
    protected $table = 'role_auth';
    protected $primaryKey = 'id';

    /**
     * 创建一个RoleAuth
     *
     * @param $roleId
     * @param $authId
     * @return bool
     */
    public static function createRoleAuth($roleId, $authId)
    {
        $roleAuth = new RoleAuth();

        $roleAuth->role_id = $roleId;
        $roleAuth->auth_id = $authId;

        $roleAuth->save();

        return true;
    }

    /**
     * 根据RoleId获取当前角色所有权限id
     *
     * @param $roleId
     * @return Array
     */
    public static function getAuthList($roleId)
    {
        $result = RoleAuth::where('role_id', $roleId)->select('auth_id')->get()->toArray();

        return array_column($result, 'auth_id');
    }
}