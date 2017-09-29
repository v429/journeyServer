<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    use SoftDeletes;

    /**
     * 创建一个角色
     *
     * @param $title
     * @return mixed
     */
    public static function createRole($title)
    {
        $role = new Role();
        $role->title = $title;

        $role->save();

        return $role->id;
    }

}