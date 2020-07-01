<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Model\AdminAuth;
use App\Service\AdminUserService;
use App\Service\Tool;
use App\Service\Traits\BaseStruct;
use Hyperf\Contract\SessionInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AdminMiddleware implements MiddlewareInterface
{
    use BaseStruct;
    /**
     * @var ContainerInterface
     */
    protected $container;
    protected $request;
    protected $response;
    protected $session;

    public function __construct(ContainerInterface $container, RequestInterface $request, HttpResponse $response, SessionInterface $session)
    {
        $this->container = $container;
        $this->request   = $request;
        $this->response  = $response;
        $this->session   = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //初始化登录信息
        $adminUserService = new AdminUserService($this->request);
        $adminUserService->loginInit($this->session);

        //登录判断
        $notLoginAction = ['public/login', 'public/loginhandle', 'public/piccode']; //无需要登录的action
        $currentRoute   = strtolower(Tool::getControllerName($this->request) . '/' . Tool::getActionName($this->request));
        if (!$adminUserService->checkLogin() && !in_array($currentRoute, $notLoginAction)) {
            if (Tool::isAjax($this->request)) {
                return $this->response->json(['code' => 0, 'msg' => '用户未登录']);
            }

            return $this->response->redirect(Tool::urlTo('/admin/public/login'));
        }

        //权限控制
        $loginUser = $adminUserService->getUser();
        if (!empty($loginUser)) {
            $result = $this->checkAuth($adminUserService, $this->request);
            if (empty($result)) {
                if (Tool::isAjax($this->request)) {
                    return $this->response->json(['code' => 0, 'msg' => $this->getError()]);
                }

                return $this->response->redirect(Tool::urlTo('/admin/public/error', ['msg' => $this->getError()]));
            }
        }

        return $handler->handle($request);
    }

    /**
     * 权限检查.
     *
     * @param AdminUserService $adminUserService
     * @param RequestInterface $request
     *
     * @return bool
     */
    private function checkAuth(AdminUserService $adminUserService, RequestInterface $request)
    {
        $role = $adminUserService->getRole();
        if (empty($role)) { //用户未分配角色
            $this->setError('当前登录用户未分配角色');

            return false;
        }
        $currentRoute = strtolower('admin_' . Tool::getControllerName($request) . '_' . Tool::getActionName($request));
        /**
         * @var AdminAuth $auth
         */
        $auth = AdminAuth::query()->where(['route' => $currentRoute])->first();
        if (empty($auth)) { //说明此路由不受权限控制
            return true;
        }
        if (1 != $role->isEnable) { //角色不存在或者禁用
            $this->setError('角色不存在或者当前角色禁用');

            return false;
        }
        $authIdArr = !empty($role->authIds ?? '') ? explode(',', $role->authIds) : [];
        if (!in_array($auth->id, $authIdArr)) { //未授权
            $this->setError('无访问权限');

            return false;
        }

        return true;
    }
}
