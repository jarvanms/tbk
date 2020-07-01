<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/12/10
 * Time: 17:31.
 */

namespace App\Controller\Admin;

use App\Service\AdminUserService;
use App\Service\System\UploadFileService;

class FileController extends BaseController
{
    /**
     * 上传图片.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function uploadImg()
    {
        $userService = new AdminUserService();
        $fileService = new UploadFileService();
        $dir         = (string) $this->request->post('dir', '');
        $result      = $fileService->uploadImg($this->request->file('singleFile'), $userService->getUserId(), 2, $dir);
        if (!$result) {
            return $this->errorJson($fileService->getError());
        }

        return $this->successJson($result);
    }
}
