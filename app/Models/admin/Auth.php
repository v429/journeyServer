<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Auth extends BaseModel
{
    protected $table = 'auth';
    protected $primaryKey = 'id';
    use SoftDeletes;

    public static $initAuths = [
        ['title'=>'用户管理', 'url' => 'backend/admin/list', 'is_menu' => 0, 'type' => 1, 'parent_id' => 0],
        ['title'=>'用户列表', 'url' => 'backend/admin/list', 'is_menu' => 1, 'type' => 2, 'parent_id' => 1],
        ['title'=>'添加用户', 'url' => 'backend/admin/add', 'is_menu' => 1, 'type' => 2, 'parent_id' => 1],
        ['title'=>'活动管理', 'url' => 'backend/active/list', 'is_menu' => 0, 'type' => 1, 'parent_id' => 0],
        ['title'=>'活动列表', 'url' => 'backend/active/list', 'is_menu' => 1, 'type' => 2, 'parent_id' => 4],
        ['title'=>'添加活动', 'url' => 'backend/active/add', 'is_menu' => 1, 'type' => 2, 'parent_id' => 4],
        ['title'=>'系统应用', 'url' => 'backend/auth/list', 'is_menu' => 0, 'type' => 1, 'parent_id' => 0],
        ['title'=>'菜单列表', 'url' => 'backend/auth/list', 'is_menu' => 1, 'type' => 2, 'parent_id' => 7],
        ['title'=>'添加菜单', 'url' => 'backend/auth/add', 'is_menu' => 1, 'type' => 2, 'parent_id' => 7],
    ];

    /**
     * 创建一个AUTH
     */
    public static function createAuth($title, $url, $isMenu, $type, $parentId)
    {
        $auth = new Auth();
        $auth->title     = $title;
        $auth->url       = $url;
        $auth->is_menu   = $isMenu;
        $auth->type      = $type;
        $auth->parent_id = $parentId;

        $auth->save();
        return $auth;
    }

    public static function getByType($type = 1)
    {
        $list = Auth::where('type', $type)->get();

        return $list;
    }

    public static function getChilds($parentId)
    {
        $childs = Auth::where('parent_id', $parentId)->get();

        return $childs;
    }

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