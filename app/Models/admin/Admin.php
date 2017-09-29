<?php

namespace App\Models;

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


}