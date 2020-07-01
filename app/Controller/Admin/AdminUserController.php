<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/11/26
 * Time: 10:52.
 */

namespace App\Controller\Admin;

use App\Model\AdminRole;
use App\Model\AdminUser;
use App\Model\SysFile;
use App\Service\AdminUserService;
use App\Service\Object\Form\AdminUserInfo;
use App\Service\Tool;
use JasonGrimes\Paginator;

class AdminUserController extends BaseController
{
    /**
     * 列表.
     *
     * @return mixed
     */
    public function index()
    {
        $page     = $this->request->query('page', 1);
        $userName = (string) trim($this->request->query('userName'));
        $where    = [];
        if (!empty($userName)) {
            $where[] = ['userName', 'like', "{$userName}%"];
        }
        $pageSize = 15; //分页大小
        $offSet   = ($page - 1) * $pageSize;
        $count    = AdminUser::query()->where($where)->count();
        $list     = AdminUser::query()->where($where)->offset($offSet)->limit($pageSize)->get()->toArray();
        if (!empty($list)) {
            //角色列表
            $roleIdArr = array_unique(array_filter(array_column($list, 'roleId')));
            if (!empty($roleIdArr)) {
                $roleList = AdminRole::query()->whereIn('id', $roleIdArr)->get()->toArray();
                if (!empty($roleList)) {
                    $roleList = array_column($roleList, null, 'id');
                }
            }
            foreach ($list as &$value) {
                $value['roleName'] = $roleList[$value['roleId']]['name'] ?? ''; //角色名称
            }
        }
        //分页
        $paginator = new Paginator($count, $pageSize, $page, Tool::getUrlPattern($this->request));

        return $this->render('admin.adminUser.index', [
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
            $result = AdminUser::query()->where(['id' => $id])->find($id)->toArray();
            if (empty($result)) {
                return $this->errorPage('数据不存在');
            }
        }
        //角色列表
        $roleList = AdminRole::query()->where(['isEnable' => 1])->get()->toArray();

        return $this->render('admin.adminUser.edit', [
            'result'   => $result,
            'roleList' => $roleList,
        ]);
    }

    /**
     * 保存菜单.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function save()
    {
        $id               = (int) $this->request->post('id', 0);
        $password         = (string) $this->request->post('password');
        $passwordConfirm  = (string) $this->request->post('passwordConfirm');
        if (!empty($password) && $password != $passwordConfirm) {
            return $this->errorJson('前后密码输入不一致');
        }
        $isModifyPassword = false;
        if (empty($id)) { //添加
            $model             = new AdminUser();
            $model->createTime = time();
            $model->password   = $password;
            $isModifyPassword  = true;
        } else { //编辑
            /**
             * @var AdminUser $model
             */
            $model = AdminUser::query()->where(['id' => $id])->find($id);
            if (empty($model)) {
                return $this->errorJson('数据不存在');
            }
            $model->updateTime = time();
            if (!empty($password)) {
                $model->password  = $password;
                $isModifyPassword = true;
            }
        }
        $model->userName  = (string) trim($this->request->post('userName'));
        $model->roleId    = (int) $this->request->post('roleId');
        $model->isEnable  = (int) $this->request->post('isEnable');
        $adminUserService = new AdminUserService();
        $result           = $adminUserService->save($model, $isModifyPassword);
        if (!$result) {
            return $this->errorJson($adminUserService->getError());
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
        $adminUserService = new AdminUserService();
        $result           = $adminUserService->delete($id);
        if (!$result) {
            return $this->errorJson($adminUserService->getError());
        }

        return $this->successJson();
    }

    /**
     * 用户资料修改.
     *
     * @return mixed
     */
    public function info()
    {
        return $this->render('admin.adminUser.info');
    }

    /**
     * 用户资料修改.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function saveInfo()
    {
        $adminUserService      = new AdminUserService();
        $info                  = new AdminUserInfo();
        $sysFileId             = $this->request->post('sysFileId', 0);
        if (!empty($sysFileId)) {
            /**
             * @var SysFile $sysFile
             */
            $sysFile = SysFile::query()->find($sysFileId);
            if (!empty($sysFile)) {
                $info->headIcon = $sysFile->relativeFilePath; //头像设置
            }
        }
        $info->userId          = $adminUserService->getUserId();
        $info->oldPassword     = $this->request->post('oldPassword');
        $info->password        = $this->request->post('password');
        $info->passwordConfirm = $this->request->post('passwordConfirm');
        $result                = $adminUserService->modifyInfo($info);
        if (!$result) {
            return $this->errorJson($adminUserService->getError());
        }
        if (!empty($sysFile)) { //标记文件为已使用
            $sysFile->isUse = 1;
            $sysFile->save();
        }

        return $this->successJson();
    }
}
