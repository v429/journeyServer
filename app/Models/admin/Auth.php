<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Auth extends BaseModel
{
    protected $table = 'auth';
    protected $primaryKey = 'id';
    use SoftDeletes;

    /**
     * 根据ID数组获取权限url列表
     *
     * @param array $idList
     * @return array
     */
    public static function getUrlsFromAuthIdList(array $idList)
    {
        $list = Auth::whereIn('id', $idList)->select('url')->get()->toArray();

        return array_column($list, 'url');
    }
}