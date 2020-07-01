<?php
use App\Service\Tool;
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <a href="<?= Tool::urlTo('/admin/adminUser/info') ?>" class="pull-left image">
                <img src="<?= !empty($loginUser['headIcon']) ? Tool::imgHtmlPath($loginUser['headIcon']) : '/img/user_head.jpg' ?>" class="img-circle" alt="User Image">
            </a>
            <div class="pull-left info">
                <p><?= $loginUser['userName'] ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form> -->
        <!-- /.search form -->


        <ul class="sidebar-menu">
            @foreach ($menuList as $valOne)
                <li class="treeview <?= $valOne['id'] == $currentTopMenuId ? 'active' : '' ?>">
                    <a href="#">
                        <i class="<?= !empty($valOne['icon']) ? $valOne['icon'] : 'glyphicon glyphicon-th' ?>"></i>
                        <span>{{ $valOne['name'] }}</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @foreach ($valOne['subList'] as $valTwo)
                        <li class="<?= $valTwo['id'] == $currentSubMenuId ? 'active' : '' ?>">
                            <a href="{{ $valTwo['route'] }}"><i class="fa fa-circle-o"></i>{{ $valTwo['name'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

    </section>
    <!-- /.sidebar -->
</aside>