<?php
namespace App\Models;

use App\Common\Utils;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auth extends BaseModel
{
    protected $table = 'auth';
    protected $primaryKey = 'id';
    use SoftDeletes;

    const AUTH_TYPE_FIRST = 1; //一级菜单
    const AUTH_TYPE_SEC   = 2; //二级菜单

    public static $addValidate = [
        'title' => 'required|max:10',
        'url'   => 'required',
        'sort'  => 'required|integer',
    ];

    public static $initAuths = [
        ['title'=>'管理员管理', 'url' => 'backend/admin/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_FIRST, 'parent_id' => 0, 'sort' => 90],
        ['title'=>'管理员列表', 'url' => 'backend/admin/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 1, 'sort' => 0 ],
        ['title'=>'添加管理员', 'url' => 'backend/admin/add', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 1, 'sort' => 0],
        ['title'=>'编辑管理员', 'url' => 'backend/admin/edit', 'is_menu' => 0, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 1, 'sort' => 0],
        ['title'=>'活动管理', 'url' => 'backend/active/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_FIRST, 'parent_id' => 0, 'sort' => 30],
        ['title'=>'活动列表', 'url' => 'backend/active/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 5, 'sort' => 0],
        ['title'=>'添加活动', 'url' => 'backend/active/add', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 5, 'sort' => 0],
        ['title'=>'编辑活动', 'url' => 'backend/active/edit', 'is_menu' => 0, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 5, 'sort' => 0],
        ['title'=>'系统应用', 'url' => 'backend/auth/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_FIRST, 'parent_id' => 0, 'sort' => 92],
        ['title'=>'菜单列表', 'url' => 'backend/auth/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 9, 'sort' => 0],
        ['title'=>'添加菜单', 'url' => 'backend/auth/add', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 9, 'sort' => 0],
        ['title'=>'编辑菜单', 'url' => 'backend/auth/edit', 'is_menu' => 0, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 9, 'sort' => 0],
        ['title'=>'角色管理', 'url' => 'backend/role/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_FIRST, 'parent_id' => 0, 'sort' => 91],
        ['title'=>'角色列表', 'url' => 'backend/role/list', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 13, 'sort' => 0],
        ['title'=>'添加角色', 'url' => 'backend/role/add', 'is_menu' => 1, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 13, 'sort' => 0],
        ['title'=>'编辑角色', 'url' => 'backend/auth/edit', 'is_menu' => 0, 'type' => self::AUTH_TYPE_SEC, 'parent_id' => 13, 'sort' => 0],
    ];

    /**
     * 创建一个AUTH
     */
    public static function createAuth($title, $url, $isMenu, $type, $parentId, $sort)
    {
        $auth = new Auth();
        $auth->title     = $title;
        $auth->url       = $url;
        $auth->is_menu   = $isMenu ? $isMenu : '0';
        $auth->type      = $type;
        $auth->parent_id = $parentId;
        $auth->sort      = $sort;

        if ($auth->save())
            return $auth;

        Utils::errorLog('add auth error in database orm');
        return false;
    }

    /**
     * 修改权限
     */
    public static function updateAuth($id, $title, $url, $isMenu, $type, $parentId, $sort)
    {
        $auth = self::getAuth($id);
        if (!$auth)
        {
            Utils::errorLog('update auth not found auth:'.$id);
            return false;
        }
        $auth->title     = $title;
        $auth->url       = $url;
        $auth->is_menu   = $isMenu ? $isMenu : '0';
        $auth->type      = $type;
        $auth->parent_id = $parentId;
        $auth->sort      = $sort;

        if ($auth->save())
            return $auth;

        Utils::errorLog('add auth error in database orm');
        return false;
    }

    /**
     * 删除菜单
     */
    public static function deleteAuth($id)
    {
        return Auth::where('id', $id)->delete();
    }

    /**
     * 获取菜单
     */
    public static function getAuth($id)
    {
        $auth = self::find($id);
        if (!$auth)
        {
            Utils::errorLog('auth not found in database');
            return false;
        }

        return $auth;
    }

    /**
     * 获取二级权限菜单树
     */
    public static function getTree($showMenu = false)
    {
        $parents = self::getByType(self::AUTH_TYPE_FIRST);

        //获取下级菜单
        foreach ($parents as $key => $parent)
        {
            $parents[$key]['childs'] = self::getChilds($parent['id'], $showMenu);
        }

        return $parents;
    }

    /**
     * 根据类型获取所有auth列表
     */
    public static function getByType($type = 1, $toArray = true)
    {
        $list = Auth::where('type', $type)->orderBy('sort', 'asc')->get();

        return $toArray ? $list->toArray() : $list;
    }

    /**
     * 根据父级ID获取所有子AUTH列表
     */
    public static function getChilds($parentId, $showMenu = false, $toArray = true)
    {
        if (!$showMenu) {
            $childs = Auth::where('parent_id', $parentId)->where('is_menu', 1)->get();
        } else {
            $childs = Auth::where('parent_id', $parentId)->get();
        }

        return $toArray ? $childs->toArray() : $childs;
    }

    /**
     * 根据ID数组获取权限url列表
     */
    public static function getUrlsFromAuthIdList(array $idList)
    {
        $list = Auth::whereIn('id', $idList)->select('url')->get()->toArray();

        return array_column($list, 'url');
    }

    /**
     * 获取auth列表
     */
    public static function getAuthList($start = 0, $limit = 15)
    {
        $list = Auth::orderBy('id', 'asc')->skip($start)->paginate($limit);

        return self::buildAuthList($list);
    }

    /**
     * 根据auth对象获取父级对象title
     */
    public static function getParentName($auth)
    {
        $parent = self::getAuth($auth->parent_id);

        if ($parent)
        {
            return $parent->title;
        }
        return '';
    }

    /**
     * 组装菜单列表
     */
    protected static function buildAuthList($list)
    {
        foreach ($list as $key => $value)
        {
            switch($value->type)
            {
                case 1:$list[$key]->type_name = '一级菜单';break;
                case 2:$list[$key]->type_name = '二级菜单';break;
                default:$list[$key]->type_name = '一级菜单';break;
            }

            $list[$key]->parent_name = self::getParentName($value);
        }

        return $list;
    }
}