<?php

namespace App\Models;

use App\Common\Utils;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends BaseModel
{

    protected $table = 'admin';
    protected $primaryKey = 'id';
    use SoftDeletes;

    /**
     * 根据ID获取一个管理员
     *
     * @param int $id
     * @return mixed
     */
    public static function getAdmin($id = 1)
    {
        return Admin::find($id);
    }

    /**
     * 根据名称或邮箱获取一个管理员
     *
     * @param $name
     * @return mixed
     */
    public static function getByNameAndEmail($name)
    {
        return Admin::where('name', $name)->orWhere('email', $name)->first();
    }

    /**
     * 获取管理员列表
     *
     * @param $start
     * @param int $limit
     * @return mixed
     */
    public static function getAdminList($start = 0, $limit = 15)
    {
        $list = Admin::orderBy('id', 'desc')->skip($start)->take($limit)->paginate($limit);

        return $list;
    }

    /**
     * 添加一个管理员
     *
     * @param $name
     * @param $password '加密后的密码字符串'
     * @param $email
     * @param $roleId
     * @return bool|mixed
     */
    public static function addAdmin($name, $password, $email, $roleId)
    {
        $admin = new Admin();
        $admin->name = $name;
        $admin->password = $password;
        $admin->email = $email;
        $admin->role_id = $roleId;
        $admin->last_login_time = null;

        if ($admin->save()) {
            return $admin->id;
        }

        Utils::errorLog('add admin error in model', compact('name', 'password', 'email', 'roleId'));
        return false;
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
     *
     * @param $id
     * @param $field
     * @param $value
     * @return bool
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