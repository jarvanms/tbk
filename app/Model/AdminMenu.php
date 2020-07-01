<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id
 * @property int $parentId
 * @property string $name
 * @property string $icon
 * @property string $route
 * @property string $controllerName
 * @property string $actionName
 * @property int $authId
 * @property int $sort
 * @property int $createTime
 * @property int $isEnable
 */
class AdminMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_menu';
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
    protected $casts = ['id' => 'integer', 'parentId' => 'integer', 'authId' => 'integer', 'sort' => 'integer', 'createTime' => 'integer', 'isEnable' => 'integer'];

    public $timestamps = false;
}