<!-- 保存在 resources/views/child.blade.php 文件中 -->
<?php
use App\Service\Tool;
?>

@extends('admin.layouts.app')

@section('title', '角色列表')


@section('content')
    <section class="content-header">
        <h1>角色管理</h1>
        <ol class="breadcrumb">
            <li><a href="{{ $homeUrl }}"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li class="active">角色列表</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">角色列表</h3>
            </div>

            <div class="box-header with-border">
                <div class="pull-left">
                    <a href="<?= Tool::urlTo('/admin/role/edit', ['returnUrl' => Tool::urlTo('/admin/role/index')]) ?>" class="btn btn-success"><span
                                class="glyphicon glyphicon-plus"></span> 添加</a>
                </div>
                <div class="pull-right">
                    <form role="form" class="form-horizontal" action="" method="get" id="search-form">
                        <div style="margin-right: 5px;" class="pull-left">
                            <input type="text" name="name" class="form-control"
                                   value="<?= $getParams['name'] ?? '' ?>" placeholder="角色名称" autocomplete="off">
                        </div>
                        <div style="" class="pull-left">
                            <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> 搜索
                            </button>
                            <a href="<?= Tool::urlTo('/admin/role/index') ?>" class="btn btn-default">清除</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="box-body">
                <form id="index_form" method="post">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th style="width: 40px">ID</th>
                            <th>角色名称</th>
                            <th style="width: 80px;">排序</th>
                            <th style="width: 200px">操作</th>
                        </tr>
                        <?php foreach ($list as $value): ?>
                        <tr>
                            <td><?= $value['id'] ?></td>
                            <td><?= $value['name'] ?></td>
                            <td><?= $value['sort'] ?></td>
                            <td>
                                <?php if ($value['isEnable'] == 1): ?>
                                <span class="label label-success">启用</span>
                                <?php else: ?>
                                <span class="label label-default">禁用</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= Tool::urlTo('/admin/role/edit', ['id' => $value['id']]) ?>"
                                   class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span>
                                    编辑</a>
                                <button link="<?= Tool::urlTo('/admin/role/delete', ['id' => $value['id']]) ?>" type="button"
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