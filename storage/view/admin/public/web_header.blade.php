<?php
use App\Service\Tool;
?>
<header class="main-header">
    <!-- Logo -->
    <a href="{{ $homeUrl }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>后台</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>后台</b>管理</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu" id="bar_consult_count" style="display: none">
                    <a href="#" title="#">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">0</span>
                    </a>
                </li>
                <li class="dropdown messages-menu" id="bar_order_count" style="display: none">
                    <a href="#" title="">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="label label-success">3</span>
                    </a>
                </li>

                <!--<li>
                    <a href="{:U('index/clearcache')}" title="清除缓存"><span class="glyphicon glyphicon-refresh"></span></a>
                </li>-->
                {{--<li>
                    <a href="javascript:;" title="语言切换" id="language_btn">
                        <span class="glyphicon glyphicon-globe"></span>
                    </a>
                    <form action="" id="language_form">
                        <input type="hidden" name="language" value="cn">
                    </form>
                    <script>
                        $("#language_btn").click(function () {
                            $("#language_form").submit();
                        });
                    </script>
                </li>--}}

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= !empty($loginUser['headIcon']) ? Tool::imgHtmlPath($loginUser['headIcon']) : '/img/user_head.jpg' ?>"
                             class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $loginUser['userName'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= !empty($loginUser['headIcon']) ? Tool::imgHtmlPath($loginUser['headIcon']) : '/img/user_head.jpg' ?>" class="img-circle" alt="User Image">

                            <!--<p>-->
                            <!--Alexander Pierce - Web Developer-->
                            <!--<small>Member since Nov. 2012</small>-->
                            <!--</p>-->
                        </li>
                        <!-- Menu Body
                        <li class="user-body">
                        <div class="row">
                        <div class="col-xs-4 text-center">
                        <a href="#">Followers</a>
                        </div>
                        <div class="col-xs-4 text-center">
                        <a href="#">Sales</a>
                        </div>
                        <div class="col-xs-4 text-center">
                        <a href="#">Friends</a>
                        </div>
                        </div>
                        </li>
                         Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= Tool::urlTo('/admin/adminUser/info') ?>" class="btn btn-default btn-flat">用户资料</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= Tool::urlTo('/admin/public/logout') ?>" class="btn btn-default btn-flat">注销</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<script>
    $(function () {
        //异步设置提醒数目
        /*var url = "Url::to(['default/noticenum'])";
        $.get(url, function (response) {
            var consultCount = parseInt(response.data.consultCount);
            var orderCount = parseInt(response.data.orderCount);

            if (consultCount <= 0) {
                $("#bar_consult_count").hide();
            } else {
                $("#bar_consult_count span").html(consultCount);
                $("#bar_consult_count").show();
            }

            if (orderCount <= 0) {
                $("#bar_order_count").hide();
            } else {
                $("#bar_order_count span").html(orderCount);
                $("#bar_order_count").show();
            }
        });*/
    });
</script>