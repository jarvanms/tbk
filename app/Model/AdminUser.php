<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id
 * @property int $roleId
 * @property string $userName
 * @property string $password
 * @property string $headIcon
 * @property string $token
 * @property int $tokenCreateTime
 * @property int $isEnable
 * @property int $lastLoginTime
 * @property string $lastLoginIp
 * @property int $createTime
 * @property int $updateTime
 */
class AdminUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_user';
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'default';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'groupId' => 'integer', 'tokenCreateTime' => 'integer', 'isEnable' => 'integer', 'lastLoginTime' => 'integer', 'createTime' => 'integer', 'updateTime' => 'integer'];

    public $timestamps = false;
}