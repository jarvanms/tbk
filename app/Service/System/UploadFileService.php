<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/12/9
 * Time: 17:29.
 */

namespace App\Service\System;

use App\Model\SysFile;
use App\Service\BaseService;
use Hyperf\HttpMessage\Upload\UploadedFile;

/**
 * 文件上传服务
 */
class UploadFileService extends BaseService
{
    private $maxSize = 2097152; //上传大小

    private $allowImgExtension = ['jpg', 'jpeg', 'png']; //图片允许上传的后缀

    private $imgDir = ['default', 'admin_user_headicon']; //图片存放目录

    /**
     * 上传单张图片.
     *
     * @param UploadedFile|null $uploadedFile
     * @param int               $userId
     * @param int               $userType
     * @param string            $saveDir
     *
     * @return array|bool
     */
    public function uploadImg(?UploadedFile $uploadedFile, int $userId, int $userType, string $saveDir = 'default')
    {
        if (empty($uploadedFile)) {
            $this->setError('上传文件不存在');

            return false;
        }
        if ($uploadedFile->getSize() > $this->maxSize) {
            $this->setError('上传文件大小超过了最大上限');

            return false;
        }
        if (!in_array($uploadedFile->getExtension(), $this->allowImgExtension)) {
            $this->setError('上传图片后缀不允许');

            return false;
        }
        if (!in_array($saveDir, $this->imgDir)) {
            $this->setError('上传图片目录参数设置非法');

            return false;
        }

        $relativePath = $saveDir . '/' . date('Y-m');
        $saveDirA     = $this->getUploadRootDir() . '/' . $saveDir;
        if (!is_dir($saveDirA)) {
            mkdir($saveDirA);
        }
        $saveDirB = $saveDirA . '/' . date('Y-m'); //月份分割
        if (!is_dir($saveDirB)) {
            mkdir($saveDirB);
        }
        $fileName = uniqid() . '.' . $uploadedFile->getExtension(); //保存文件名
        //保存文件
        $absolutePath = $saveDirB . '/' . $fileName;
        $uploadedFile->moveTo($absolutePath);
        $relativeFilePath = $relativePath . '/' . $fileName;
        $originalFileName = $uploadedFile->getClientFilename();
        /**
         * @var SysFile $file
         */
        $file                   = new SysFile();
        $file->createUserId     = $userId;
        $file->userType         = $userType;
        $file->originalFileName = $originalFileName;
        $file->fileDir          = $saveDir;
        $file->absolutePath     = $absolutePath;
        $file->relativeFilePath = $relativeFilePath;
        $file->createTime       = time();
        if (!$file->save()) {
            $this->setError('数据保存失败');

            return false;
        }

        return [
            'url'              => config('domain') . '/upload/' . $relativeFilePath,
            'relativeFilePath' => $relativeFilePath,
            'sysFileId'        => $file->id,
            'originalFileName' => $originalFileName,
        ];
    }

    /**
     * 上传文件根路径.
     *
     * @return string
     */
    public function getUploadRootDir()
    {
        return BASE_PATH . '/' . 'public/upload';
    }
}
