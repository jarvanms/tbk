<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 19/10/18
 * Time: 16:21.
 */

namespace App\Controller\Admin;

use App\Controller\Controller;
use App\Model\AdminMenu;
use App\Service\AdminUserService;
use App\Service\Tool;

class BaseController extends Controller
{
    /**
     * @param string $template
     * @param array  $data
     *
     * @return mixed
     */
    protected function render(string $template, array $data = [])
    {
        $data['resourcePre'] = '';
        $data['homeUrl']     = Tool::urlTo($this->homeUrl);
        $data['_csrf']       = '';
        $data['getParams']   = $this->request->query(); //get参数
        $data['loginUser']   = [];
        $data['menuList']    = [];

        //登录状态设置的数据
        $adminUserService = new AdminUserService();
        $loginUser        = $adminUserService->getUser();
        if (!empty($loginUser)) {
            $role      = $adminUserService->getRole();
            $authIdArr = !empty($role->authIds ?? []) ? explode(',', $role->authIds) : []; //当前登录用户的权限id列表
            //登录用户信息
            $data['loginUser'] = ['userName' => $loginUser->userName, 'headIcon' => $loginUser->headIcon];
            //后台菜单
            $currentRoute   = strtolower(Tool::getControllerName($this->request) . '/' . Tool::getActionName($this->request));
            $menuList       = AdminMenu::query()->where(['parentId' => 0, 'isEnable' => 1])->get()->toArray();
            if (!empty($menuList)) {
                foreach ($menuList as $key => &$value) {
                    $value['subList'] = AdminMenu::query()->where(['parentId' => $value['id'], 'isEnable' => 1])->get()->toArray();
                    if (!empty($value['subList'])) {
                        foreach ($value['subList'] as $subKey => &$subVal) {
                            //判断当前菜单是否有访问权限，若无权限则是显示菜单(authId > 0说明菜单配置了权限控制)
                            if ($subVal['authId'] > 0 &&!in_array($subVal['authId'], $authIdArr)) {
                                unset($value['subList'][$subKey]);
                                continue;
                            }
                            //设置当前展开的菜单
                            $menuRoute = strtolower($subVal['controllerName'] . '/' . $subVal['actionName']);
                            if ($menuRoute == $currentRoute) {
                                $this->session->set('currentTopMenuId', $value['id']);
                                $this->session->set('currentSubMenuId', $subVal['id']);
                            }
                        }
                        $value['subList'] = array_values($value['subList']);
                    }
                    if (empty($value['subList'])) { //没有子菜单时，父菜单不作显示
                        unset($menuList[$key]);
                    }
                }
                $menuList = array_values($menuList);
            }
            $data['menuList']         = $menuList;
            $data['currentTopMenuId'] = $this->session->get('currentTopMenuId', 0);
            $data['currentSubMenuId'] = $this->session->get('currentSubMenuId', 0);
        }

        return $this->render->render($template, $data);
    }
}
