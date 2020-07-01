<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 *
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Service\ConstantService;
use Hyperf\Contract\SessionInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;
use Psr\Container\ContainerInterface;

abstract class Controller
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;
    /**
     * @var RenderInterface
     */
    protected $render;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var SessionInterface
     */
    protected $session;

    protected $homeUrl = '/admin/menu/index';

    public function __construct(ContainerInterface $container)
    {
        $this->container   = $container;
        $this->request     = $container->get(RequestInterface::class);
        $this->response    = $container->get(ResponseInterface::class);
        $this->render      = $container->get(RenderInterface::class);
        $this->session     = $container->get(SessionInterface::class);
    }

    /**
     * 成功json响应.
     *
     * @param mixed  $data
     * @param string $msg
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function successJson($data = [], string $msg = '操作成功')
    {
        return $this->response->json(['code' => ConstantService::CODE_SUCCESS, 'msg' => $msg, 'data' => $data]);
    }

    /**
     * 失败json响应.
     *
     * @param string $msg
     * @param mixed  $data
     * @param int    $code
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function errorJson(string $msg = '操作失败', $data = [], int $code = ConstantService::CODE_FAIL)
    {
        return $this->response->json(['code' => $code, 'msg' => $msg, 'data' => $data]);
    }

    /**
     * 操作出错.
     *
     * @param string $msg
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function errorPage(string $msg = '操作错误啦')
    {
        return $this->response->redirect('/admin/public/error?msg=' . $msg);
    }
}
