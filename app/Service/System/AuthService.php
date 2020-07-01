<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/12/3
 * Time: 14:12.
 */

namespace App\Service\System;

use App\Model\AdminAuth;
use App\Service\BaseService;

class AuthService extends BaseService
{
    /**
     * 权限保存.
     *
     * @param AdminAuth $auth
     *
     * @return bool
     */
    public function save(AdminAuth $auth)
    {
        if (!$auth->name) {
            $this->setError('请输入权限名称');

            return false;
        }
        //检查权限路由是否重复
        /*if ($auth->parentId > 0) {
            $query = AdminAuth::query()->where(['route' => $auth->route]);
            if ($auth->id > 0) {
                $query->where('id', '<>', $auth->id);
            }
            $exist = $query->first();
            if (!empty($exist)) {
                $this->setError('当前路由已经存在');

                return false;
            }
        }*/
        if (!$auth->save()) {
            $this->setError('保存数据失败');

            return false;
        }

        return true;
    }

    /**
     * 权限删除.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id)
    {
        $result = AdminAuth::query()->where(['id' => $id])->delete();
        if (!$result) {
            $this->setError('删除数据失败');

            return false;
        }

        return true;
    }

    /**
     * 获取权限列表.
     *
     * @return array
     */
    public function getAuthList()
    {
        $authList = AdminAuth::query()->where(['parentId' => 0, 'isEnable' => 1])->orderBy('sort', 'desc')->get()->toArray();
        if (empty($authList)) {
            return [];
        }
        foreach ($authList as &$value) {
            $value['subList'] = AdminAuth::query()->where(['parentId' => $value['id'], 'isEnable' => 1])->orderBy('sort', 'desc')->get()->toArray();
        }

        return $authList;
    }
}
