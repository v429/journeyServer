<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Auth extends BaseModel
{
    protected $table = 'auth';
    protected $primaryKey = 'id';
    use SoftDeletes;

    const AUTH_TYPE_FIRST = 1; //一级菜单
    const AUTH_TYPE_SEC   = 2; //二级菜单

    public static $initAuths = [
        ['title'=>'管理员管理', 'url' => 'backend/admin/list', 'is_menu' => 0, 'type' => self::AUTH_TYPE_FIRST, 'parent_id' => 0],
        ['title'=>'管理员列表', 'url' => 'backend/admin/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 1],
        ['title'=>'添加管理员', 'url' => 'backend/admin/add', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 1],
        ['title'=>'活动管理', 'url' => 'backend/active/list', 'is_menu' => 0, 'type' => self::AUTH_TYPE_FIRST, 'parent_id' => 0],
        ['title'=>'活动列表', 'url' => 'backend/active/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 4],
        ['title'=>'添加活动', 'url' => 'backend/active/add', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 4],
        ['title'=>'系统应用', 'url' => 'backend/auth/list', 'is_menu' => 0, 'type' => self::AUTH_TYPE_FIRST, 'parent_id' => 0],
        ['title'=>'菜单列表', 'url' => 'backend/auth/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 7],
        ['title'=>'添加菜单', 'url' => 'backend/auth/add', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 7],
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

    /**
     * 获取二级权限菜单树
     *
     * @return mixed
     */
    public static function getTree()
    {
        $parents = self::getByType(self::AUTH_TYPE_FIRST);

        //获取下级菜单
        foreach ($parents as $key => $parent)
        {
            $parents[$key]['childs'] = self::getChilds($parent['id']);
        }

        return $parents;
    }

    /**
     * 根据类型获取所有auth列表
     *
     * @param int $type
     * @return mixed
     */
    public static function getByType($type = 1, $toArray = true)
    {
        $list = Auth::where('type', $type)->get();

        return $toArray ? $list->toArray() : $list;
    }

    /**
     * 根据父级ID获取所有子AUTH列表
     *
     * @param $parentId
     * @return mixed
     */
    public static function getChilds($parentId, $toArray = true)
    {
        $childs = Auth::where('parent_id', $parentId)->get();

        return $toArray ? $childs->toArray() : $childs;
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