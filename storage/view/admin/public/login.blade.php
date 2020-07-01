<?php
use App\Service\Tool;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台 | 登录</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/index2.html"><b>后台</b>登录</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><!-- Sign in to start your session --></p>

        <form action="{{ Tool::urlTo('/admin/public/loginhandle') }}" method="post" id="login_form">
            <input type="hidden" name="_csrf" value="">
            <div class="form-group has-feedback">
                <input type="text" name="userName" class="form-control" placeholder="用户名">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="verifyCode" class="form-control" style="width: 150px;float: left" placeholder="输入验证码" autocomplete="off">
                <img src="<?= Tool::urlTo('/admin/public/picCode') ?>" title="点击刷新验证码" onClick="get_code(this);" class="verify_img"/>
            </div>
            <div class="row">
                <div class="col-xs-8" style="margin-top: 10px;">
                    {{--<div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="rememberUser"> 记住登录状态
                        </label>
                    </div>--}}
                </div>
                <!-- /.col -->
                <div class="col-xs-4" style="margin-top: 10px;">
                    <button type="button" class="btn btn-primary btn-block btn-flat" id="login_btn">登 录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <!-- /.social-auth-links -->

        <!-- <a href="#">I forgot my password</a><br> -->

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<style>
    .verify_img{
        height: 35px;
        float: left;
        margin-left: 5px;
    }
</style>

<!-- jQuery 2.2.3 -->
<script src="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/plugins/iCheck/icheck.min.js"></script>
<script>
    //刷新验证码
    function get_code(obj)
    {
        var timestamp = Date.parse(new Date());
        url = "<?= Tool::urlTo('/admin/public/picCode') ?>?refresh=" + timestamp;
        $.ajax({
            url: url,
            // dataType: 'json',
            cache: false,
            success: function (data) {
                //将验证码图片中的图片地址更换
                $(".verify_img").attr('src', url);
            }
        });
    }

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        /*    $('#myModal').modal()                      // initialized with defaults
         $('#myModal').modal({ keyboard: false })   // initialized with no keyboard
         $('#myModal').modal('show')                // initializes and invokes show immediately*/

        $("#login_btn").click(function () {
            var url = $("#login_form").attr("action");
            var data = $("#login_form").serialize();
            $.post(url, data, function (response) {
                if (response.code == 1) {
                    window.location.href = "<?= $homeUrl ?>";
                } else if (response.code == 0) {
                    $(".verify_img").trigger("click");
                    alert(response.msg);
                } else {
                    $(".verify_img").trigger("click");
                }
            });
        });
    });
</script>
</body>
</html>