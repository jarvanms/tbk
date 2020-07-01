<!-- 保存在 resources/views/child.blade.php 文件中 -->
<?php
use App\Service\Tool;
?>

@extends('admin.layouts.app')

@section('title', '管理员列表')


@section('content')
    <section class="content-header">
        <h1>管理员管理</h1>
        <ol class="breadcrumb">
            <li><a href="{{ $homeUrl }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li class="active">管理员列表</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">管理员列表</h3>
            </div>

            <div class="box-header with-border">
                <div class="pull-left">
                    <a href="<?= Tool::urlTo('/admin/adminUser/edit', ['returnUrl' => Tool::urlTo('/admin/adminUser/index')]) ?>" class="btn btn-success"><span
                                class="glyphicon glyphicon-plus"></span> 添加</a>
                </div>
                <div class="pull-right">
                    <form role="form" class="form-horizontal" action="" method="get" id="search-form">
                        <div style="margin-right: 5px;" class="pull-left">
                            <input type="text" name="userName" class="form-control"
                                   value="<?= $getParams['userName'] ?? '' ?>" placeholder="管理员名称" autocomplete="off">
                        </div>
                        <div style="" class="pull-left">
                            <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> 搜索
                            </button>
                            <a href="<?= Tool::urlTo('/admin/adminUser/index') ?>" class="btn btn-default">清除</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="box-body">
                <form id="index_form" method="post">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th style="width: 40px">ID</th>
                            <th>管理员用户名</th>
                            <th>角色</th>
                            <th>创建时间</th>
                            <th>修改时间</th>
                            <th>最后登录时间</th>
                            <th>最后登录IP</th>
                            <th style="width: 80px;">状态</th>
                            <th style="width: 200px">操作</th>
                        </tr>
                        <?php foreach ($list as $value): ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['userName'] ?></td>
                            <td><?= $value['roleName'] ?></td>
                            <td><?= date('Y-m-d H:i', $value['createTime']) ?></td>
                            <td><?= !empty($value['updateTime']) ? date('Y-m-d H:i', $value['updateTime']) : '' ?></td>
                            <td><?= !empty($value['lastLoginTime']) ? date('Y-m-d H:i', $value['lastLoginTime']) : '' ?></td>
                            <td><?= $value['lastLoginIp'] ?></td>
                            <td>
                                <?php if ($value['isEnable'] == 1): ?>
                                <span class="label label-success">启用</span>
                                <?php else: ?>
                                <span class="label label-default">禁用</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= Tool::urlTo('/admin/adminUser/edit', ['id' => $value['id']]) ?>"
                                   class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span>
                                    编辑</a>
                                <button link="<?= Tool::urlTo('/admin/adminUser/delete', ['id' => $value['id']]) ?>" type="button"
                                        class="btn btn-danger btn-sm del_confirm">
                                    <span class="glyphicon glyphicon-trash"></span> 删除
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </form>
            </div>

            <div class="box-footer clearfix">
                <?= $paginatorHtml ?>
            </div>

        </div>
        <!-- /.box -->
    </section>
@endsection