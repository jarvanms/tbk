<?php
use App\Service\Tool;
?>
@extends('admin.layouts.app')

@section('title', '管理员编辑')

@section('content')
<section class="content-header">
    <h1>
        管理员管理
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= $homeUrl ?>"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="<?= Tool::urlTo('/admin/adminUser/index') ?>">管理员列表</a></li>
        <li class="active">管理员编辑</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">管理员编辑</h3>
        </div>
        <form role="form" action="<?= Tool::urlTo('/admin/adminUser/save')  ?>" method="post" id="ajax_post_form">
            <input type="hidden" name="id" value="<?= $result['id'] ?? 0 ?>">
            <input type="hidden" name="_csrf" value="<?= $_csrf ?>">
            <div class="box-body">
                <div class="form-group" style="margin-top: 10px">
                    <label for="menufor">用户名</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="userName" value="<?= $result['userName'] ?? '' ?>"
                                   class="form-control" id="menufor" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>密码</label>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <input type="password" name="password"
                                   class="form-control" minlength="6" maxlength="12" autocomplete="new-password" placeholder="6-12位字符">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>确认密码</label>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <input type="password" name="passwordConfirm" class="form-control" minlength="6" maxlength="12">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>角色</label>
                    <div class="row">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <select name="roleId" class="form-control">
                                <option value="0">请选择...</option>
                                <?php foreach ($roleList as $value): ?>
                                <option value="<?= $value['id'] ?>" <?php if(!empty($result) && $result['roleId'] == $value['id']): ?> selected <?php endif; ?> >
                                    <?= $value['name'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="select">
                    <label>状态</label>
                    <div class="row">
                        <div class="col-sm-2 col-sm-2 col-lg-2">
                            <select name="isEnable" class="form-control">
                                <option value="1">启用</option>
                                <option value="0" <?php if (!empty($result) && $result['isEnable'] == 0): ?> selected <?php endif;?> >禁用</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-primary" id="ajax_post_submit">提交</button>
                <a href="<?= !empty($_GET['returnUrl']) ? urldecode($_GET['returnUrl']) : Tool::urlTo('/admin/adminUser/index') ?>" class="btn btn-success">返回</a>
            </div>
        </form>
    </div>
</section>
@endsection