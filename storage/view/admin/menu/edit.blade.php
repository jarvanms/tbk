<?php
use App\Service\Tool;
?>
@extends('admin.layouts.app')

@section('title', '菜单编辑与添加')

@section('content')
<section class="content-header">
    <h1>
        菜单管理
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= $homeUrl ?>"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="<?= Tool::urlTo('/admin/menu/index') ?>">菜单列表</a></li>
        <li class="active">菜单添加/编辑</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">菜单添加/编辑</h3>
        </div>
        <form role="form" action="<?= Tool::urlTo('/admin/menu/save')  ?>" method="post" id="ajax_post_form">
            <input type="hidden" name="id" value="<?= $result['id'] ?? 0 ?>">
            <input type="hidden" name="_csrf" value="<?= $_csrf ?>">
            <div class="box-body">
                <div class="select">
                    <label>父菜单</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <select name="parentId" class="form-control">
                                <option value="0">顶级菜单</option>
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
                    <label for="menufor">菜单名称</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="name" value="<?= $result['name'] ?? '' ?>"
                                   class="form-control" id="menufor">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>icon</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="icon" value="<?= $result['icon'] ?? '' ?>"
                                   class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>url</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="route" value="<?= $result['route'] ?? '' ?>"
                                   class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>控制器名称</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="controllerName"
                                   value="<?= $result['controllerName'] ?? '' ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>操作名称</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="actionName" value="<?= $result['actionName'] ?? '' ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>归属权限</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <select name="authId" class="form-control">
                                <option value="0">请选择...</option>
                                <?php foreach ($authList as $value): ?>
                                    <option value="<?= $value['id'] ?>" disabled><?= $value['name'] ?></option>
                                    <?php foreach ($value['subList'] as $subVal): ?>
                                        <option value="<?= $subVal['id'] ?>" <?php if (!empty($result) && $result['authId'] == $subVal['id']): ?> selected <?php endif; ?> >
                                            &emsp;|--<?= $subVal['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </select>
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
                <a href="<?= !empty($_GET['returnUrl']) ? urldecode($_GET['returnUrl']) : Tool::urlTo('/admin/menu/index') ?>" class="btn btn-success">返回</a>
            </div>
        </form>
    </div>
</section>
@endsection