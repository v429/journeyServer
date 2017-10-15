<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Auth;
use App\Services\rbacService;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class SystemController extends Controller
{

    /**
     * 角色列表页面
     */
    public function roleList()
    {
        $roles = rbacService::getRoleList();

        $this->data['roles'] = $roles;
        $this->pageTitle = '角色列表';

        return $this->display('backend.system.role-list');
    }

    /**
     * 添加角色页面
     */
    public function addRole()
    {
        $authTree = rbacService::getTree();

        $this->data['authTree'] = $authTree;
        $this->pageTitle = '添加角色';

        return $this->display('backend.system.role-add');
    }

    /**
     * 添加角色接口
     */
    public function createRole(Request $request)
    {
        $name = $request->get('name');
        $authIds = $request->get('auth_ids');

        if (!$name) {
            $this->errorOut('角色标题不能为空');
        }

        $roleId = rbacService::addRole($name, $authIds);

        if ($roleId) {
            $this->successOut('添加成功');
        }

        $this->errorOut('添加失败');
    }

    /**
     * 编辑角色页面
     */
    public function editRole(Request $request)
    {
        $id = $request->get('id');

        $role = rbacService::getRole($id);

        $tree = rbacService::getTree();
        if ($role) {
            $this->data['role'] = $role['role'];
            $this->data['auths'] = $role['auths'];
            $this->data['authTree'] = $tree;
            $this->pageTitle = '编辑角色';

            return $this->display('backend.system.edit-role');
        }

        return $this->errPage('角色未找到');
    }

    /**
     * 修改角色接口
     */
    public function updateRole(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('name');
        $authIds = $request->get('auth_ids');

        if (!$id || !$name) {
            $this->errorOut('参数不正确');
        }

        if (rbacService::updateRole($id, $name, $authIds)) {
            $this->successOut('修改成功');
        }

        $this->errorOut('修改失败');
    }

    /**
     * 权限列表页
     */
    public function authList()
    {
        $list = rbacService::getAuthList(0, env('BACKEND_ITEM_PERPAGE'));

        $this->data['auths'] = $list;
        $this->pageTitle = '菜单列表';

        return $this->display('backend.system.auth-list');
    }

    /**
     * 添加菜单页面
     */
    public function addAuth()
    {
        $parents = rbacService::getAllParent();

        $this->data['parents'] = $parents;
        $this->pageTitle = '添加菜单';

        return $this->display('backend.system.auth-add');
    }

    /**
     * 添加菜单接口
     */
    public function createAuth(Request $request)
    {
        $validater = Validator::make($request->all(), Auth::$addValidate);
        if ($validater->fails())
        {
            $this->errorOut($validater->messages());
        }

        $title    = $request->get('title');
        $url      = $request->get('url');
        $isMenu   = $request->get('is_menu');
        $type     = $request->get('type');
        $parentId = $request->get('parent_id');
        $sort     = $request->get('sort');

        if ($type == Auth::AUTH_TYPE_SEC && !$parentId)
        {
            $this->errorOut('请选择父级菜单');
        }

        $rs = rbacService::addAuth($title, $url, $isMenu, $type, $parentId, $sort);

        if ($rs)
        {
            $this->successOut('添加成功');
        }

        $this->errorOut('添加失败');
    }

    /**
     * 编辑菜单页面
     */
    public function editAuth(Request $request)
    {
        $id = $request->get('id', 0);

        $auth = rbacService::getAuth($id);
        if (!$auth)
        {
            return $this->errPage('权限不存在');
        }

        $parents = rbacService::getAllParent();

        $this->data['parents'] = $parents;
        $this->data['auth'] = $auth;
        $this->pageTitle = '编辑菜单';

        return $this->display('backend/system/auth-edit');
    }

    /**
     * 修改权限接口
     */
    public function updateAuth(Request $request)
    {
        $validater = Validator::make($request->all(), Auth::$addValidate);
        if ($validater->fails())
        {
            $this->errorOut($validater->messages());
        }

        $id = $request->get('id');
        $title    = $request->get('title');
        $url      = $request->get('url');
        $isMenu   = $request->get('is_menu');
        $type     = $request->get('type');
        $parentId = $request->get('parent_id');
        $sort     = $request->get('sort');

        if ($type == Auth::AUTH_TYPE_SEC && !$parentId)
        {
            $this->errorOut('请选择父级菜单');
        }

        $rs = rbacService::updateAuth($id, $title, $url, $isMenu, $type, $parentId, $sort);

        if ($rs)
        {
            $this->successOut('修改成功');
        }

        $this->errorOut('修改失败');
    }

    /**
     * 删除菜单接口
     */
    public function delAuth(Request $request)
    {
        $id = $request->get('id');

        $rs = rbacService::deleteAuth($id);

        if ($rs)
        {
            $this->successOut('删除成功');
        }

        $this->errorOut('删除失败');
    }

}