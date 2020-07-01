<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/11/26
 * Time: 10:52.
 */

namespace App\Controller\Admin;

use App\Model\AdminAuth;
use App\Service\System\AuthService;
use App\Service\Tool;
use JasonGrimes\Paginator;

class AuthController extends BaseController
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
        $count    = AdminAuth::query()->where($where)->count();
        $list     = AdminAuth::query()->where($where)->offset($offSet)->limit($pageSize)->get()->toArray();
        if (!empty($list)) {
            $parentIdArr = array_unique(array_filter(array_column($list, 'parentId')));
            if (!empty($parentIdArr)) {
                $parentData = AdminAuth::query()->whereIn('id', $parentIdArr)->get()->toArray();
                if (!empty($parentData)) {
                    $parentData = array_column($parentData, null, 'id');
                }
            }
            foreach ($list as &$value) {
                if (0 == $value['parentId']) {
                    $value['parentName'] = '顶级菜单';
                } else {
                    $value['parentName'] = $parentData[$value['parentId']]['name'] ?? '';
                }
            }
        }

        //父菜单，用于搜索
        $parentList = AdminAuth::query()->where(['parentId' => 0])->get()->toArray();

        //分页
        $paginator = new Paginator($count, $pageSize, $page, Tool::getUrlPattern($this->request));

        return $this->render('admin.auth.index', [
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
        $parentList = AdminAuth::query()->where(['parentId' => 0])->get()->toArray();
        $id         = (int) $this->request->query('id', 0);
        $result     = [];
        if (!empty($id)) {
            $result = AdminAuth::query()->where(['id' => $id])->find($id)->toArray();
            if (empty($result)) {
                return $this->errorPage('数据不存在');
            }
        }

        return $this->render('admin.auth.edit', [
            'parentList' => $parentList,
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
            $model = new AdminAuth();
        } else { //编辑
            /**
             * @var AdminAuth $model
             */
            $model = AdminAuth::query()->where(['id' => $id])->find($id);
            if (empty($model)) {
                return $this->errorJson('数据不存在');
            }
        }
        $model->name      = (string) $this->request->post('name');
        $model->parentId  = (int) $this->request->post('parentId');
        $model->route     = (string) $this->request->post('route');
        $model->sort      = (int) $this->request->post('sort');
        $model->isEnable  = (int) $this->request->post('isEnable');
        $authService      = new AuthService();
        $result           = $authService->save($model);
        if (!$result) {
            return $this->errorJson($authService->getError());
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
        $authService = new AuthService();
        $result      = $authService->delete($id);
        if (!$result) {
            return $this->errorJson($authService->getError());
        }

        return $this->successJson();
    }
}
