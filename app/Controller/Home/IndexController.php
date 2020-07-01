<?php
/**
 * Created by PhpStorm.
 * User: luojiawen
 * Date: 20/1/7
 * Time: 17:33.
 */

namespace App\Controller\Home;

use App\Controller\Controller;

class IndexController extends Controller
{
    public function test()
    {
        return $this->successJson('hello home index');
    }
}
