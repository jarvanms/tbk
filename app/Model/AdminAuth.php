<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $parentId 
 * @property string $name 
 * @property string $route 
 * @property int $sort 
 * @property int $isEnable 
 */
class AdminAuth extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_auth';
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
    protected $casts = ['id' => 'int', 'parentId' => 'integer', 'sort' => 'integer', 'isEnable' => 'integer'];

    public $timestamps = false;
}