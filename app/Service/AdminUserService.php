<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/10/23
 * Time: 16:08.
 */

namespace App\Service;

use App\Model\AdminRole;
use App\Model\AdminUser;
use App\Service\Object\Form\AdminUserInfo;
use Hyperf\Contract\SessionInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;

class AdminUserService extends BaseService
{
    const LOGIN_SESSION_KEY = 'loginAdminUserId';
    private $request;
    private $userId = 0;
    /**
     * @var AdminUser
     */
    private $user;
    /**
     * @var AdminRole
     */
    private $role;

    public function __construct(RequestInterface $request = null)
    {
        $this->request = $request;
    }

    /**
     * 添加与更新后台用户.
     *
     * @param AdminUser $user
     * @param bool      $isModifyPassword 是否修改密码
     *
     * @return bool
     */
    public function save(AdminUser $user, bool $isModifyPassword = false)
    {
        if (!$user->userName) {
            $this->setError('请输入用户名');

            return false;
        }
        if ($isModifyPassword) {
            if (!$user->password) {
                $this->setError('请输入密码');

                return false;
            }
            if (strlen($user->password) < 5 && strlen($user->password) > 12) {
                $this->setError('密码长度5-12位');

                return false;
            }
            $user->password = Tool::encryptPassword($user->password);
        }
        if (!$user->roleId) {
            $this->setError('请选择用户角色');

            return false;
        }
        //判断用户名是否存在
        $where = [['userName', '=', $user->userName]];
        if ($user->id) {
            $where[] = ['id', '<>', $user->id];
        }
        $exist = AdminUser::query()->where($where)->first();
        if (!empty($exist)) {
            $this->setError('用户名已存在');

            return false;
        }
        if (!$user->save()) {
            $this->setError('保存失败');

            return false;
        }

        return true;
    }

    /**
     * 管理员删除.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id)
    {
        $result = AdminUser::query()->where(['id' => $id])->delete();
        if (!$result) {
            $this->setError('删除数据失败');

            return false;
        }

        return true;
    }

    /**
     * 修改用户数据.
     *
     * @param AdminUserInfo $info
     *
     * @return bool
     */
    public function modifyInfo(AdminUserInfo $info)
    {
        /**
         * @var AdminUser $user
         */
        $user = AdminUser::query()->find($info->userId);
        if (empty($user)) {
            $this->setError('用户数据不存在');

            return false;
        }
        if ($info->password) {
            if ($user->password != Tool::encryptPassword($info->oldPassword)) {
                $this->setError('原密码输入错误');

                return false;
            }
            $passwordLength = strlen($info->password);
            if ($passwordLength < 6 || $passwordLength > 12) {
                $this->setError('密码长度6-12位');

                return false;
            }
            if ($info->password != $info->passwordConfirm) {
                $this->setError('密码前后不一致');

                return false;
            }
            $user->password = Tool::encryptPassword($info->password);
        }
        if ($info->headIcon) { //头像修改
            $user->headIcon = $info->headIcon;
            $oldHeadIcon    = $user->getOriginal('headIcon');
        }
        $user->updateTime = time();
        if (!$user->save()) {
            $this->setError('数据保存失败');

            return false;
        }
        if ($info->headIcon && !empty($oldHeadIcon)) { //删除旧头像图片
            $filePath = Tool::getFileAbsolutePath($oldHeadIcon);
            file_exists($filePath) && unlink($filePath);
        }

        return true;
    }

    /**
     * 后台用户登录(登录成功时方法返回user model).
     *
     * @param string $userName
     * @param string $password
     *
     * @return AdminUser|bool
     */
    public function login(string $userName, string $password)
    {
        /**
         * @var AdminUser $user
         */
        $user = AdminUser::query()->where(['userName' => $userName])->first();
        if (empty($userName)) {
            $this->setError('用户名或者密码输入错误');

            return false;
        }
        if ($user->password != Tool::encryptPassword($password)) {
            $this->setError('用户名或者密码输入错误');

            return false;
        }

        return $user;
    }

    /**
     * 登录用户信息初始化.
     *
     * @param SessionInterface $session
     *
     * @return bool
     */
    public function loginInit(SessionInterface $session)
    {
        $loginAdminUserId = (int) $session->get(self::LOGIN_SESSION_KEY);
        if (empty($loginAdminUserId)) {
            $this->setError('sesssion中无用户数据');

            return false;
        }
        /**
         * @var AdminUser $adminUser
         */
        $adminUser = AdminUser::query()->find($loginAdminUserId);
        if (empty($adminUser)) {
            $this->setError('用户数据不存在');

            return false;
        }
        if (1 != $adminUser->isEnable) {
            $this->setError('用户帐号禁用状态');

            return false;
        }
        $this->setUserId((int) $adminUser->id);
        $this->setUser($adminUser);
        if ($adminUser->roleId > 0) {
            /**
             * @var AdminRole $role
             */
            $role = AdminRole::query()->find($adminUser->roleId);
            $this->setRole($role);
        }

        return true;
    }

    /**
     * 当前用户是否登录.
     *
     * @return bool
     */
    public function checkLogin()
    {
        $userId = $this->getUserId();
        if (empty($userId)) {
            return false;
        }

        return true;
    }

    /**
     * 用户注销登录.
     *
     * @param SessionInterface $session
     *
     * @return bool
     */
    public function logout(SessionInterface $session)
    {
        if (!$this->checkLogin()) {
            return true;
        }
        $session->remove(self::LOGIN_SESSION_KEY);

        return true;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        $userId = Context::get('userId', 0);

        return (int) $userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        Context::set('userId', $userId);
        $this->userId = $userId;
    }

    /**
     * @return AdminUser
     */
    public function getUser(): ?AdminUser
    {
        $adminUser = Context::get('AdminUser', null);

        return $adminUser instanceof AdminUser ? $adminUser : null;
    }

    /**
     * @param AdminUser $user
     */
    public function setUser(?AdminUser $user): void
    {
        Context::set('AdminUser', $user);
        $this->user = $user;
    }

    /**
     * @return AdminRole
     */
    public function getRole(): ?AdminRole
    {
        $adminRole = Context::get('AdminRole', null);

        return $adminRole instanceof AdminRole ? $adminRole : null;
    }

    /**
     * @param AdminRole $role
     */
    public function setRole(?AdminRole $role): void
    {
        Context::set('AdminRole', $role);
        $this->role = $role;
    }
}
