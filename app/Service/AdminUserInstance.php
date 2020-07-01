<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/12/2
 * Time: 15:52.
 */

namespace App\Service;

use App\Model\AdminRole;
use App\Model\AdminUser;
use Hyperf\Utils\Traits\StaticInstance;

class AdminUserInstance
{
    use StaticInstance;

    public $userId;
    /**
     * @var AdminUser
     */
    public $user;
    /**
     * @var AdminRole
     */
    public $role;
}
