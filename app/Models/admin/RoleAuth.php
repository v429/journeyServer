<?php

namespace App\Models;

use App\Common\Utils;
use Illuminate\Support\Facades\DB;

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
     * 批量添加role auth
     */
    public static function createRoleAuths($roleId, array $authIds)
    {
        $datas = array();
        foreach ($authIds as $key => $aid)
        {
            $datas[$key]['role_id'] = $roleId;
            $datas[$key]['auth_id'] = $aid;
        }

        if (DB::table('role_auth')->insert($datas))
        {
            return true;
        }

        Utils::errorLog('add role auth error in mysql');
        return false;
    }

    /**
     * 修改role auth
     */
    public static function updateRoleAuth($roleId, $authIds)
    {
        //先清除之前的权限
        $isExist = RoleAuth::where('role_id', $roleId)->first();
        if ($isExist)
        {
            $del = RoleAuth::where('role_id', $roleId)->delete();
            if (!$del)
            {
                Utils::errorLog('edit role: ' . $roleId . ' auth error in mysql del old auth');
                return false;
            }
        }
        //执行修改
        $datas = array();
        foreach ($authIds as $key => $aid) {
            $datas[$key]['role_id'] = $roleId;
            $datas[$key]['auth_id'] = $aid;
        }

        if (DB::table('role_auth')->insert($datas)) {
            return true;
        }
        Utils::errorLog('edit role: ' . $roleId . ' auth error in mysql del old auth');
        return false;
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

    /**
     * 根据AUTH ID 删除记录
     *
     * @param $authId
     * @return mixed
     */
    public static function deleteRoleAuthByAuth($authId)
    {
        RoleAuth::where('auth_id', $authId)->delete();
        return true;
    }
}