<?php

namespace App\Models;

class RoleAuth extends BaseModel
{
    protected $table = 'role_auth';
    protected $primaryKey = 'id';

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