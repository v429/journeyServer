<?php

namespace App\Models;

use App\Common\Utils;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends BaseModel
{

    const ADMIN_STATUS_ENABLE = 1; //管理员状态启用
    const ADMIN_STATUS_STOP   = 0; //管理员状态停用

    protected $table = 'admin';
    protected $primaryKey = 'id';
    use SoftDeletes;

    public static $addValidate = [
        'name'     => 'required|max:16',
        'password' => 'required|min:6|max:20',
        'email'    => 'required|email',
    ];

    public static $editValidate = [
        'name'     => 'required|max:16',
        'email'    => 'required|email',
    ];

    /**
     * 根据ID获取一个管理员
     */
    public static function getAdmin($id = 1)
    {
        return Admin::find($id);
    }

    /**
     * 根据名称或邮箱获取一个管理员
     */
    public static function getByNameAndEmail($name)
    {
        return Admin::where('name', $name)->orWhere('email', $name)->first();
    }

    /**
     * 获取管理员列表
     */
    public static function getAdminList($start = 0, $limit = 15)
    {
        $list = Admin::orderBy('id', 'desc')->skip($start)->take($limit)->paginate($limit);

        return $list;
    }

    /**
     * 添加一个管理员
     *
     * @param $password '加密后的密码字符串'
     */
    public static function addAdmin($name, $password, $email, $roleId)
    {
        $admin = new Admin();
        $admin->name = $name;
        $admin->password = $password;
        $admin->email = $email;
        $admin->role_id = $roleId;
        $admin->last_login_time = null;
        $admin->status = self::ADMIN_STATUS_ENABLE;

        if ($admin->save()) {
            return $admin->id;
        }

        Utils::errorLog('add admin error in model', compact('name', 'password', 'email', 'roleId'));
        return false;
    }

    /**
     * 修改管理员属性
     */
    public static function updateAdmin($id, $name, $email, $roleId)
    {
        $admin = Admin::find($id);

        if (!$admin)
        {
            Utils::errorLog('update admin:' . $id . ' not found');
            return false;
        }

        $admin->name = $name;
        $admin->email = $email;
        $admin->role_id = $roleId;

        if ($admin->save())
        {
            return true;
        }

        Utils::errorLog('update admin:' . $id . ' error', compact('name', 'email', 'roleId'));
        return false;
    }

    /**
     * 修改用户单一属性
     */
    public static function updateAdminAttr($id, $field, $value)
    {
        $admin = Admin::find($id);

        if (!$admin)
        {
            Utils::errorLog('update admin:' . $id . ' not found');
            return false;
        }

        $admin->$field = $value;

        if ($admin->save())
            return true;

        Utils::errorLog('update admin:' . $id . ' error, update field:' . $field . '; value : '. $value);
        return false;
    }


}