<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/11/26
 * Time: 10:52.
 */

namespace App\Controller\Admin;

use App\Model\AdminAuth;
use App\Model\AdminMenu;
use App\Request\MenuSaveRequest;
use App\Service\System\AuthService;
use App\Service\Tool;
use JasonGrimes\Paginator;

class MenuController extends BaseController
{
    /**
     * 列表.
     *
     * @return mixed
     */
    public function index()
    {
        $page     = $this->request->query('page', 1);
        $name     = (string) $this->request->query('name');
        $parentId = (int) $this->request->query('parentId', 0);
        $where    = [];
        if (!empty($name)) {
            $where[] = ['name', 'like', "{$name}%"];
        }
        if (!empty($parentId)) {
            $where[] = ['parentId', '=', $parentId];
        }
        $pageSize = 15; //分页大小
        $offSet   = ($page - 1) * $pageSize;
        $count    = AdminMenu::query()->where($where)->count();
        $list     = AdminMenu::query()->where($where)->offset($offSet)->limit($pageSize)->get()->toArray();
        if (!empty($list)) {
            //父菜单数据
            $parentIdArr = array_unique(array_filter(array_column($list, 'parentId')));
            if (!empty($parentIdArr)) {
                $parentData = AdminMenu::query()->whereIn('id', $parentIdArr)->get()->toArray();
                if (!empty($parentData)) {
                    $parentData = array_column($parentData, null, 'id');
                }
            }
            //权限数据
            $authIdArr = array_unique(array_filter(array_column($list, 'authId')));
            if (!empty($authIdArr)) {
                $authData = AdminAuth::query()->whereIn('id', $authIdArr)->get()->toArray();
                if (!empty($authData)) {
                    $authData = array_column($authData, null, 'id');
                }
            }
            foreach ($list as &$value) {
                if (0 == $value['parentId']) {
                    $value['parentName'] = '顶级菜单';
                } else {
                    $value['parentName'] = $parentData[$value['parentId']]['name'] ?? ''; //父菜单名称
                }
                $value['authName'] = $authData[$value['authId']]['name'] ?? ''; //归属权限名称
            }
        }

        //父菜单，用于搜索
        $parentList = AdminMenu::query()->where(['parentId' => 0])->get()->toArray();

        //分页
        $paginator = new Paginator($count, $pageSize, $page, Tool::getUrlPattern($this->request));

        return $this->render('admin.menu.index', [
            'list'          => $list,
            'paginatorHtml' => $paginator->toHtml(),
            'parentList'    => $parentList,
        ]);
    }

    /**
     * @return mixed
     */
    public function edit()
    {
        $parentList = AdminMenu::query()->where(['parentId' => 0])->get()->toArray();
        $id         = (int) $this->request->query('id', 0);
        $result     = [];
        if (!empty($id)) {
            $result = AdminMenu::query()->where(['id' => $id])->find($id)->toArray();
            if (empty($result)) {
                return $this->errorPage('数据不存在');
            }
        }
        //权限列表
        $authService = new AuthService();
        $authList    = $authService->getAuthList();

        return $this->render('admin.menu.edit', [
            'parentList' => $parentList,
            'result'     => $result,
            'authList'   => $authList,
        ]);
    }

    /**
     * 保存菜单.
     *
     * @param MenuSaveRequest $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function save(MenuSaveRequest $request)
    {
        $id = (int) $this->request->post('id', 0);
        if (empty($id)) { //添加
            $menu = new AdminMenu();
        } else { //编辑
            /**
             * @var AdminMenu $menu
             */
            $menu = AdminMenu::query()->where(['id' => $id])->find($id);
            if (empty($menu)) {
                return $this->errorJson('数据不存在');
            }
        }
        $menu->name           = (string) $this->request->post('name');
        $menu->parentId       = (int) $this->request->post('parentId');
        $menu->icon           = (string) $this->request->post('icon');
        $menu->route          = (string) $this->request->post('route');
        $menu->controllerName = (string) $this->request->post('controllerName');
        $menu->actionName     = (string) $this->request->post('actionName');
        $menu->authId         = (int) $this->request->post('authId');
        $menu->sort           = (int) $this->request->post('sort');
        $menu->isEnable       = (int) $this->request->post('isEnable');
        if (empty($id)) {
            $menu->createTime = time();
        }
        if (!$menu->save()) {
            return $this->errorJson('数据保存失败');
        }

        return $this->successJson();
    }

    /**
     * 数据删除.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete()
    {
        $id = (int) $this->request->query('id', 0);
        if (empty($id)) {
            return $this->errorJson('数据id错误');
        }
        $delResult = AdminMenu::query()->where(['id' => $id])->delete();
        if (!$delResult) {
            return $this->errorJson('删除失败');
        }

        return $this->successJson();
    }
}
