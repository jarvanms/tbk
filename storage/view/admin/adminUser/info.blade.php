<?php
use App\Service\Tool;
?>
@extends('admin.layouts.app')

@section('title', '用户资料')

@section('content')
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">用户资料</h3>
            </div>
            <form role="form" action="<?= Tool::urlTo('/admin/adminUser/saveInfo')  ?>" method="post" id="ajax_post_form">
                <input type="hidden" name="_csrf" value="<?= $_csrf ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label for="menufor">我的头像</label>
                        <div class="row">
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <img style="width: 45%;cursor: pointer" class="img-circle" id="profile_photo_show" title="修改"
                                     src="<?= !empty($loginUser['headIcon']) ? Tool::imgHtmlPath($loginUser['headIcon']) : '/img/user_head.jpg' ?>">
                                <input type="file" id="uploadfile" name="singleFile" style="display: none" />
                                <input type="hidden" name="sysFileId">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>原密码</label>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <input type="password" name="oldPassword" class="form-control" minlength="6" maxlength="12" autocomplete="new-password" placeholder="请输入原密码">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>密码</label>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <input type="password" name="password" class="form-control" minlength="6" maxlength="12" autocomplete="new-password" placeholder="6-12位字符">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>确认密码</label>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <input type="password" name="passwordConfirm" class="form-control" minlength="6" maxlength="12" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-primary" id="ajax_post_submit">提交</button>
                </div>
            </form>
        </div>
    </section>

    <!--异步上传js组件-->
    <script src="<?= $resourcePre ?>/plugins/jQuery-File-Upload-9.12.5/js/vendor/jquery.ui.widget.js"></script>
    <script src="<?= $resourcePre ?>/plugins/jQuery-File-Upload-9.12.5/js/jquery.iframe-transport.js"></script>
    <script src="<?= $resourcePre ?>/plugins/jQuery-File-Upload-9.12.5/js/jquery.fileupload.js"></script>
    <script>
        $(function () {
            //文件上传
            var uploadUrl = "<?= Tool::urlTo('/admin/file/uploadImg') ?>";
            $("#profile_photo_show").click(function(){
                $("#uploadfile").click();
            });
            $('#uploadfile').fileupload({
                url: uploadUrl,
                formData:{dir: 'admin_user_headicon'},
                dataType: 'json',
                done: function(e, data) {
                    var result = data.result;
                    if (result.code == 1) {
                        $("#profile_photo_show").attr('src', result.data.url);
                        $("[name='sysFileId']").val(result.data.sysFileId);
                    } else {
                        alert(result.msg);
                    }
                },
                progressall: function(e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            });
        });
    </script>
@endsection