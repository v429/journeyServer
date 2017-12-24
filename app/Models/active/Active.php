<?php

namespace App\Models;

use App\Common\Utils;
use Illuminate\Database\Eloquent\SoftDeletes;

class Active extends BaseModel {

    protected $table = 'active';
    protected $primaryKey = 'id';
    use SoftDeletes;

    const ACTIVE_STATUS_READY = 1;
    const ACTIVE_STATUS_WAITING = 2;
    const ACTIVE_STATUS_PLAYING = 3;
    const ACTIVE_STATUS_DONE = 4;
    const ACTIVE_STATUS_STOP = 0;

    public static function addActive()
    {

    }

    /**
     * 根据ID获取一个活动
     */
    public static function getActive($id)
    {
        $active = Active::find($id);
        if (!$active)
        {
            Utils::errorLog('active:'. $id . ' not found');
        }

        return $active;
    }

    /**
     * 获取活动列表
     */
    public static function getList($limit = 15)
    {
        $list = Active::orderBy('id', 'desc')->paginate($limit);

        return $list;
    }

}