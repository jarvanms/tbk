<!-- 保存在 resources/views/layouts/app.blade.php 文件中 -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>App Name - @yield('title')</title>
    <link rel="Shortcut Icon" href="{{ $resourcePre }}/favicon.ico">
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
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/dist/css/skins/_all-skins.min.css">
    <!-- jQuery 2.2.3 -->
    <script src="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--colorbox css-->
    <link rel="stylesheet" type="text/css" href="{{ $resourcePre }}/plugins/colorbox/images/colorbox7/colorbox.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

    @include('admin.public.web_header')

    @include('admin.public.web_left_bar')

    <div class="content-wrapper">
        @yield('content')
    </div>

    @include('admin.public.web_footerinfo')

</div>

<!---------------操作提示 S------------------->
<div class="example-modal">
    <div class="modal modal-success" id="modal-success-id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">操作提示</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-success-content">操作成功</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="example-modal">
    <div class="modal modal-warning" id="modal-warning-id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">操作提示</h4>
                </div>
                <div class="modal-body">
                    <p id="modal-warning-content">操作失败</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!---------------操作提示 E------------------->

</body>

<script type="text/javascript">
    function successShow(content='') {
        if (content != '') {
            $("#modal-success-content").html(content);
        }
        $("#modal-success-id").modal('show');
        setTimeout("$('#modal-success-id').modal('hide')", 1500);
    }
    function failShow(content='') {
        if (content != '') {
            $("#modal-warning-content").html(content);
        }
        $("#modal-warning-id").modal('show');
        setTimeout("$('#modal-warning-id').modal('hide')", 2000);
    }
    function failShowNotClose(content) {
        if (content != '') {
            $("#modal-warning-content").html(content);
        }
        $("#modal-warning-id").modal('show');
    }
</script>

<script type="text/javascript">
    $(function () {
        //列表单条数据删除操作(GET方式)
        $(".del_confirm").click(function () {
            var link = $(this).attr("link");
            var data = {_csrf:"<?= $_csrf ?? '' ?>"};
            if (confirm('删除数据后不可恢复！确认删除？')) {
                $.post(link, data, function (response) {
                    if (response.code == 1) {
                        location.reload();
                    } else {
                        failShow(response.msg);
                    }
                })
            }
        });
        //列表集合删除操作(POST方式)
        $("#delete_all_btn").click(function () {
            var link = $(this).attr("link");
            if (confirm('删除数据后不可恢复！确认删除？')) {
                $("#index_form").attr("action", link);
                $("#index_form").submit();
            }
        });
        //全选与反选
        $("[name='checkbox_all']:checkbox").click(function () {
            var current_status = this.checked;
            $("[name='checkbox_single[]']:checkbox").each(function () {
                this.checked = current_status;
            });
        });
    });
</script>


<script type="text/javascript">
    $(function () {
        //表单异步提交
        $("#ajax_post_submit").click(function () {
            var url = $("#ajax_post_form").attr("action");
            var data = $("#ajax_post_form").serialize();
            $.post(url, data, function (response) {
                if (response.code == 1) {
                    successShow(response.msg);
                    setTimeout(function () {
                        var returnUrl = "<?= $getParams['returnUrl'] ?? '' ?>";
                        if (returnUrl == '') {
                            location.reload();
                        } else {
                            window.location.href = returnUrl;
                        }
                    }, 1500);
                } else if (response.code == 0) {
                    failShow(response.msg);
                } else {
                    failShow('状态未知!');
                }
            });
        });

        //表单异步提交(用于colorbox)
        $("#ajax_colorbox_submit").click(function () {
            var url = $("#ajax_colorbox_form").attr("action");
            var data = $("#ajax_colorbox_form").serialize();
            $.post(url, data, function (response) {
                if (response.code == 1) {
                    successShow(response.msg);
                    setTimeout("parent.location.reload();", 1500);
                } else if (response.code == 0) {
                    failShow(response.msg);
                } else {
                    failShow('状态未知!');
                }
            });
        });
    });
</script>

<!-- Bootstrap 3.3.6 -->
<script src="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/dist/js/demo.js"></script>

<link rel="stylesheet" href="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/plugins/datepicker/datepicker3.css">
<script src="{{ $resourcePre }}/plugins/AdminLTE-2.3.11/plugins/datepicker/bootstrap-datepicker.js"></script>

<!--colorbox js-->
<script type="text/javascript" src="{{ $resourcePre }}/plugins/colorbox/js/jquery.colorbox.js"></script>
<script type="text/javascript" src="{{ $resourcePre }}/plugins/colorbox/mycolorbox.js"></script>
</html>