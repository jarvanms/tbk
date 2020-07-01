<?php
use App\Service\Tool;
?>
@extends('admin.layouts.app')

@section('title', '权限编辑')

@section('content')
<section class="content-header">
    <h1>
        权限管理
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= $homeUrl ?>"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="<?= Tool::urlTo('/admin/auth/index') ?>">权限列表</a></li>
        <li class="active">权限添加/编辑</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">权限添加/编辑</h3>
        </div>
        <form role="form" action="<?= Tool::urlTo('/admin/auth/save')  ?>" method="post" id="ajax_post_form">
            <input type="hidden" name="id" value="<?= $result['id'] ?? 0 ?>">
            <input type="hidden" name="_csrf" value="<?= $_csrf ?>">
            <div class="box-body">
                <div class="select">
                    <label>父权限</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <select name="parentId" class="form-control">
                                <option value="0">顶级权限</option>
                                <?php foreach ($parentList as $value): ?>
                                    <option value="<?= $value['id'] ?>" <?php if (!empty($result) && $result['parentId'] == $value['id']): ?> selected <?php endif; ?> >
                                        <?= $value['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 10px">
                    <label for="menufor">权限名称</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="name" value="<?= $result['name'] ?? '' ?>"
                                   class="form-control" id="menufor">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>路由</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="route" value="<?= $result['route'] ?? '' ?>" class="form-control" placeholder="路由名称(module_controller_action)">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>排序</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="sort" value="<?= $result['sort'] ?? '100' ?>"
                                   class="form-control">
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
                <a href="<?= !empty($_GET['returnUrl']) ? urldecode($_GET['returnUrl']) : Tool::urlTo('/admin/auth/index') ?>" class="btn btn-success">返回</a>
            </div>
        </form>
    </div>
</section>
@endsection