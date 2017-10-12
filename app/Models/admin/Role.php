<?php

namespace App\Models;

use App\Common\Utils;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    use SoftDeletes;

    /**
     * 获取角色
     */
    public static function getRole($roleId)
    {
        $role = self::find($roleId);
        if (!$role)
        {
            Utils::errorLog('role not found', ['role_id' => $roleId]);
            return false;
        }
        return $role;
    }

    /**
     * 创建一个角色
     */
    public static function createRole($title)
    {
        $role = new Role();
        $role->title = $title;

        $role->save();

        return $role->id;
    }

    /**
     * 获取角色列表
     */
    public static function getRoleList($start = 0, $limit = 15)
    {
        $roleObj = Role::orderBy('id', 'desc');

        if ($limit != -1)
            return $roleObj->skip($start)->take($limit)->paginate();

        return $roleObj->get();
    }


}