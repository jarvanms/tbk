<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/12/9
 * Time: 16:32.
 */

namespace App\Service\Object\Form;

use App\Service\Object\BaseObject;

/**
 * Class AdminUserInfo.
 *
 * @property int    $userId          用户id
 * @property string $oldPassword     原密码
 * @property string $password        密码
 * @property string $passwordConfirm 确认密码
 * @property string $headIcon        头像
 */
class AdminUserInfo extends BaseObject
{
}
