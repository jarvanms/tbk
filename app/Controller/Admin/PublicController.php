<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/10/18
 * Time: 16:22.
 */

namespace App\Controller\Admin;

use App\Service\AdminUserService;
use App\Service\ConstantService;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Hyperf\HttpMessage\Stream\SwooleStream;

class PublicController extends BaseController
{
    /**
     * 登录界面.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function login()
    {
        $userService = new AdminUserService();
        if ($userService->checkLogin()) {
            return $this->response->redirect($this->homeUrl);
        }

        return $this->render('admin.public.login');
    }

    /**
     * 登录处理.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function loginhandle()
    {
        $userName    = $this->request->post('userName', '');
        $password    = $this->request->post('password', '');
        $verifyCode  = $this->request->post('verifyCode', '');
        //验证码
        $picCodeContent = $this->session->get('picCodeContent');
        if (strtolower($picCodeContent) != $verifyCode) {
            return $this->errorJson('验证码输入错误');
        }
        $userService = new AdminUserService();
        $result      = $userService->login($userName, $password);
        if (!$result) {
            return $this->errorJson($userService->getError());
        }

        //写入会话
        $this->session->set(AdminUserService::LOGIN_SESSION_KEY, $result->id);

        return $this->response->json(['code' => ConstantService::CODE_SUCCESS, 'msg' => '登录成功']);
    }

    /**
     * 图片验证码
     *
     * @return mixed
     */
    public function picCode()
    {
        $width         = $this->request->input('width', 150);
        $height        = $this->request->input('height', 40);
        $length        = 4;
        $phraseBuilder = new PhraseBuilder($length);
        $builder       = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build($width, $height);
        $phrase = $builder->getPhrase(); //验证码内容
        $this->session->set('picCodeContent', $phrase); //设置到seesion
        $output = $builder->get();

        return $this->response
            ->withAddedHeader('content-type', 'image/jpeg')
            ->withBody(new SwooleStream($output));
    }

    /**
     * 注销登录.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function logout()
    {
        $userService = new AdminUserService($this->request);
        $userService->logout($this->session);

        return $this->response->redirect('/admin/public/login');
    }

    /**
     * 错误页面.
     *
     * @return mixed
     */
    public function error()
    {
        $msg = $this->request->query('msg', '');

        return $this->render('error', ['msg' => $msg]);
    }
}
