<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $fileDir
 * @property string $absolutePath 
 * @property string $relativeFilePath 
 * @property string $originalFileName 
 * @property int $createUserId 
 * @property int $userType 
 * @property int $isUse 
 * @property int $createTime 
 */
class SysFile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_file';
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
    protected $casts = ['id' => 'int', 'fileDir' => 'integer', 'createUserId' => 'integer', 'userType' => 'integer', 'isUse' => 'integer', 'createTime' => 'integer'];

    public $timestamps = false;
}