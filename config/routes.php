<?php

declare(strict_types=1);
/*
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

//后台模块
Router::addGroup('/admin/', function () {
    //公共操作
    Router::get('public/login', [App\Controller\Admin\PublicController::class, 'login']);
    Router::post('public/loginhandle', [App\Controller\Admin\PublicController::class, 'loginhandle']);
    Router::get('public/error', [App\Controller\Admin\PublicController::class, 'error']);
    Router::get('public/logout', [App\Controller\Admin\PublicController::class, 'logout']);
    Router::get('public/picCode', [App\Controller\Admin\PublicController::class, 'picCode']);
    //菜单管理
    Router::get('menu/index', [\App\Controller\Admin\MenuController::class, 'index']);
    Router::get('menu/edit', [\App\Controller\Admin\MenuController::class, 'edit']);
    Router::post('menu/save', [\App\Controller\Admin\MenuController::class, 'save']);
    Router::post('menu/delete', [\App\Controller\Admin\MenuController::class, 'delete']);
    //权限管理
    Router::get('auth/index', [\App\Controller\Admin\AuthController::class, 'index']);
    Router::get('auth/edit', [\App\Controller\Admin\AuthController::class, 'edit']);
    Router::post('auth/save', [\App\Controller\Admin\AuthController::class, 'save']);
    Router::post('auth/delete', [\App\Controller\Admin\AuthController::class, 'delete']);
    //角色管理
    Router::get('role/index', [\App\Controller\Admin\RoleController::class, 'index']);
    Router::get('role/edit', [\App\Controller\Admin\RoleController::class, 'edit']);
    Router::post('role/save', [\App\Controller\Admin\RoleController::class, 'save']);
    Router::post('role/delete', [\App\Controller\Admin\RoleController::class, 'delete']);
    //管理员管理
    Router::get('adminUser/index', [\App\Controller\Admin\AdminUserController::class, 'index']);
    Router::get('adminUser/edit', [\App\Controller\Admin\AdminUserController::class, 'edit']);
    Router::post('adminUser/save', [\App\Controller\Admin\AdminUserController::class, 'save']);
    Router::post('adminUser/delete', [\App\Controller\Admin\AdminUserController::class, 'delete']);
    Router::get('adminUser/info', [\App\Controller\Admin\AdminUserController::class, 'info']);
    Router::post('adminUser/saveInfo', [\App\Controller\Admin\AdminUserController::class, 'saveInfo']);
    //文件上传
    Router::post('file/uploadImg', [\App\Controller\Admin\FileController::class, 'uploadImg']);
}, ['middleware' => [App\Middleware\AdminMiddleware::class]]);

//前台模块
Router::addGroup('/home/', function () {
    Router::get('index/test', [App\Controller\Home\IndexController::class, 'test']);
});
