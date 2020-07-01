<?php
use App\Service\Tool;
?>
@extends('admin.layouts.app')

@section('title', '角色编辑')

@section('content')
<section class="content-header">
    <h1>
        角色管理
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= $homeUrl ?>"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="<?= Tool::urlTo('/admin/role/index') ?>">角色列表</a></li>
        <li class="active">角色编辑</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">角色编辑</h3>
        </div>
        <form role="form" action="<?= Tool::urlTo('/admin/role/save')  ?>" method="post" id="ajax_post_form">
            <input type="hidden" name="id" value="<?= $result['id'] ?? 0 ?>">
            <input type="hidden" name="_csrf" value="<?= $_csrf ?>">
            <div class="box-body">
                <div class="form-group" style="margin-top: 10px">
                    <label for="menufor">角色名称</label>
                    <div class="row">
                        <div class="col-sm-3 col-sm-3 col-lg-3">
                            <input type="text" name="name" value="<?= $result['name'] ?? '' ?>"
                                   class="form-control" id="menufor">
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
                <?php foreach ($authList as $valueA): ?>
                <div class="form-group auth-group" style="margin-top: 15px">
                    <label class="auth-group-name"><?= $valueA['name'] ?></label>
                    <div class="row">
                        <?php foreach ($valueA['subList'] as $valueB): ?>
                        <div class="col-sm-2 col-sm-2 col-lg-2">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" <?php if (!empty($result) && in_array($valueB['id'], $result['authIds'])): ?> checked <?php endif; ?>
                                    name="authIds[]" value="<?= $valueB['id'] ?>" class="auth-checkbox"> <?= $valueB['name'] ?>
                                </label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-primary" id="ajax_post_submit">提交</button>
                <a href="<?= !empty($_GET['returnUrl']) ? urldecode($_GET['returnUrl']) : Tool::urlTo('/admin/role/index') ?>" class="btn btn-success">返回</a>
            </div>
        </form>
    </div>
</section>
<script>
    $(function () {
        //点击权限组名称时，全选与反选
        $(".auth-group-name").click(function () {
            var checked = $(this).parent(".auth-group").find(".auth-checkbox:first").prop('checked');
            $(this).parent(".auth-group").find(":checkbox").each(function(){
                this.checked = checked;
            });
        });
    });
</script>
@endsection