<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/11/26
 * Time: 10:52.
 */

namespace App\Controller\Admin;

use App\Model\AdminRole;
use App\Service\System\AuthService;
use App\Service\System\RoleService;
use App\Service\Tool;
use JasonGrimes\Paginator;

class RoleController extends BaseController
{
    /**
     * 列表.
     *
     * @return mixed
     */
    public function index()
    {
        $page     = $this->request->query('page', 1);
        $name     = (string) trim($this->request->query('name'));
        $where    = [];
        if (!empty($name)) {
            $where[] = ['name', 'like', "{$name}%"];
        }
        $pageSize = 15; //分页大小
        $offSet   = ($page - 1) * $pageSize;
        $count    = AdminRole::query()->where($where)->count();
        $list     = AdminRole::query()->where($where)->offset($offSet)->limit($pageSize)->get()->toArray();
        //分页
        $paginator = new Paginator($count, $pageSize, $page, Tool::getUrlPattern($this->request));

        return $this->render('admin.role.index', [
            'list'          => $list,
            'paginatorHtml' => $paginator->toHtml(),
        ]);
    }

    /**
     * @return mixed
     */
    public function edit()
    {
        $id     = (int) $this->request->query('id', 0);
        $result = [];
        if (!empty($id)) {
            $result = AdminRole::query()->where(['id' => $id])->find($id)->toArray();
            if (empty($result)) {
                return $this->errorPage('数据不存在');
            }
            $result['authIds'] = !empty($result['authIds']) ? explode(',', $result['authIds']) : [];
        }
        $authService = new AuthService();
        $authList    = $authService->getAuthList();

        return $this->render('admin.role.edit', [
            'authList'   => $authList,
            'result'     => $result,
        ]);
    }

    /**
     * 保存菜单.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function save()
    {
        $id = (int) $this->request->post('id', 0);
        if (empty($id)) { //添加
            $model = new AdminRole();
            $model->createTime = time();
        } else { //编辑
            /**
             * @var AdminRole $model
             */
            $model = AdminRole::query()->where(['id' => $id])->find($id);
            if (empty($model)) {
                return $this->errorJson('数据不存在');
            }
            $model->updateTime = time();
        }
        $authIdArr        = (array) $this->request->post('authIds');
        $authIds          = !empty($authIdArr) ? implode(',', $authIdArr) : ''; //权限id，逗号分割
        $model->name      = (string) $this->request->post('name');
        $model->authIds   = $authIds;
        $model->sort      = (int) $this->request->post('sort');
        $model->isEnable  = (int) $this->request->post('isEnable');
        $roleService      = new RoleService();
        $result           = $roleService->save($model);
        if (!$result) {
            return $this->errorJson($roleService->getError());
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
        $roleService      = new RoleService();
        $result           = $roleService->delete($id);
        if (!$result) {
            return $this->errorJson($roleService->getError());
        }

        return $this->successJson();
    }
}
