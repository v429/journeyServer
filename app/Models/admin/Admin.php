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


}