<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/12/3
 * Time: 14:44.
 */

namespace App\Service\System;

use App\Model\AdminRole;
use App\Service\BaseService;

class RoleService extends BaseService
{
    /**
     * 角色保存.
     *
     * @param AdminRole $role
     *
     * @return bool
     */
    public function save(AdminRole $role)
    {
        if (!$role->name) {
            $this->setError('请输入角色名称');

            return false;
        }
        if (!$role->save()) {
            $this->setError('保存数据失败');

            return false;
        }

        return true;
    }

    /**
     * 角色删除.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id)
    {
        $result = AdminRole::query()->where(['id' => $id])->delete();
        if (!$result) {
            $this->setError('删除数据失败');

            return false;
        }

        return true;
    }
}
