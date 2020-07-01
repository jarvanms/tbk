/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50721
Source Host           : localhost:3306
Source Database       : hyperf_system

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2019-12-20 14:26:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sky_admin_auth
-- ----------------------------
DROP TABLE IF EXISTS `sky_admin_auth`;
CREATE TABLE `sky_admin_auth` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `parentId` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '权限名称',
  `route` varchar(100) NOT NULL DEFAULT '' COMMENT '路由名称(module_controller_action)',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `isEnable` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0禁用 1启动',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of sky_admin_auth
-- ----------------------------
INSERT INTO `sky_admin_auth` VALUES ('17', '0', '菜单管理', '', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('18', '17', '菜单列表', 'admin_menu_index', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('19', '17', '菜单保存', 'admin_menu_save', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('20', '17', '菜单删除', 'admin_menu_delete', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('21', '0', '权限管理', '', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('22', '21', '权限列表', 'admin_auth_index', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('23', '21', '权限查看', 'admin_auth_edit', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('24', '21', '权限保存', 'admin_auth_save', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('25', '21', '权限删除', 'admin_auth_delete', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('26', '0', '角色管理', '', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('27', '26', '角色列表', 'admin_role_index', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('28', '26', '角色查看', 'admin_role_edit', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('29', '26', '角色保存', 'admin_role_save', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('30', '26', '角色删除', 'admin_role_delete', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('31', '0', '管理员管理', '', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('32', '31', '管理员列表', 'admin_adminuser_index', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('33', '31', '管理员查看', 'admin_adminuser_edit', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('34', '31', '管理员保存', 'admin_adminuser_save', '100', '1');
INSERT INTO `sky_admin_auth` VALUES ('35', '31', '管理员删除', 'admin_adminuser_delete', '100', '1');

-- ----------------------------
-- Table structure for sky_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `sky_admin_menu`;
CREATE TABLE `sky_admin_menu` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `parentId` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `route` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单路由',
  `controllerName` varchar(20) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `actionName` varchar(20) NOT NULL DEFAULT '' COMMENT '操作名称',
  `authId` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属权限id',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `createTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建日期',
  `isEnable` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0禁用 1启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='后台菜单';

-- ----------------------------
-- Records of sky_admin_menu
-- ----------------------------
INSERT INTO `sky_admin_menu` VALUES ('1', '0', '系统管理', '11', '#', '', '', '0', '100', '0', '1');
INSERT INTO `sky_admin_menu` VALUES ('2', '0', '用户管理', '', '#', '', '', '0', '100', '0', '1');
INSERT INTO `sky_admin_menu` VALUES ('3', '0', '配置管理', '', '#', '', '', '0', '100', '0', '1');
INSERT INTO `sky_admin_menu` VALUES ('4', '1', '菜单列表', '', '/admin/menu/index', 'menu', 'index', '18', '100', '1574926532', '1');
INSERT INTO `sky_admin_menu` VALUES ('5', '1', '角色管理', '', '/admin/role/index', 'role', 'index', '27', '100', '1575346803', '1');
INSERT INTO `sky_admin_menu` VALUES ('6', '1', '权限管理', '', '/admin/auth/index', 'auth', 'index', '22', '100', '1575347007', '1');
INSERT INTO `sky_admin_menu` VALUES ('7', '1', '管理员', '', '/admin/adminUser/index', 'adminUser', 'index', '32', '100', '1575365551', '1');

-- ----------------------------
-- Table structure for sky_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `sky_admin_role`;
CREATE TABLE `sky_admin_role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '角色名称',
  `authIds` varchar(1000) NOT NULL DEFAULT '' COMMENT '权限id(逗号分割保存)',
  `sort` smallint(5) NOT NULL DEFAULT '100' COMMENT '排序',
  `createTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建日期',
  `updateTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新日期',
  `isEnable` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1启用 0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='后台用户角色';

-- ----------------------------
-- Records of sky_admin_role
-- ----------------------------
INSERT INTO `sky_admin_role` VALUES ('5', '超级管理员', '18,19,20,22,23,24,25,27,28,29,30,32,33,34,35', '100', '1575359408', '1575517830', '1');

-- ----------------------------
-- Table structure for sky_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `sky_admin_user`;
CREATE TABLE `sky_admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '后台用户id',
  `roleId` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户角色id',
  `userName` char(15) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `headIcon` varchar(100) NOT NULL DEFAULT '' COMMENT '头像',
  `token` varchar(64) NOT NULL DEFAULT '' COMMENT '登录cookie值',
  `tokenCreateTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'token创建日期',
  `isEnable` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1启用 0禁用',
  `lastLoginTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录日期',
  `lastLoginIp` varchar(30) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `createTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建日期',
  `updateTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新日期',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userName` (`userName`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of sky_admin_user
-- ----------------------------
INSERT INTO `sky_admin_user` VALUES ('1', '5', 'maple', 'b3357e4b9ffca90f1279f5df6018b628', '', '95425b90-756b-66ef-edd8-e9ce29ad83e1', '1561295809', '1', '1561295809', '::1', '0', '1576134268');
INSERT INTO `sky_admin_user` VALUES ('8', '5', 'jarvan', '$2y$13$WLUIRv3CzXkw/0hWRIZcuuG3SS/7qjiFQtbdxKhMC0u131emyT/GC', '', '992dcff2-20b0-707a-1ab6-31cfb4e8c51d', '1512740299', '1', '1512740299', '::1', '1512051593', '1575430156');

-- ----------------------------
-- Table structure for sky_sys_file
-- ----------------------------
DROP TABLE IF EXISTS `sky_sys_file`;
CREATE TABLE `sky_sys_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件上传记录id',
  `fileDir` varchar(30) NOT NULL DEFAULT '' COMMENT '文件存放目录名',
  `absolutePath` varchar(100) NOT NULL DEFAULT '' COMMENT '文件绝对路径',
  `relativeFilePath` varchar(100) NOT NULL DEFAULT '' COMMENT '文件相对路径',
  `originalFileName` varchar(100) NOT NULL DEFAULT '' COMMENT '原文件名',
  `createUserId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建用户id',
  `userType` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '用户分类 1前台用户 2后台用户',
  `isUse` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否使用了(0未使用 1已使用)，未使用的文件会定期清除',
  `createTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='文件上传记录';

-- ----------------------------
-- Records of sky_sys_file
-- ----------------------------
INSERT INTO `sky_sys_file` VALUES ('1', 'admin_user_headicon', '/mnt/share/hyperf-skeleton/public/upload/admin_user_headicon/2019-12/5df1befad4663.jpg', 'admin_user_headicon/2019-12/5df1befad4663.jpg', 'b64543a98226cffcf90a9972bf014a90f703eaca.jpg', '1', '2', '0', '1576124154');
INSERT INTO `sky_sys_file` VALUES ('2', 'admin_user_headicon', '/mnt/share/hyperf-skeleton/public/upload/admin_user_headicon/2019-12/5df1bf39d3d8c.jpg', 'admin_user_headicon/2019-12/5df1bf39d3d8c.jpg', 'b64543a98226cffcf90a9972bf014a90f703eaca.jpg', '1', '2', '0', '1576124217');
INSERT INTO `sky_sys_file` VALUES ('3', 'admin_user_headicon', '/mnt/share/hyperf-skeleton/public/upload/admin_user_headicon/2019-12/5df1deb52b642.jpg', 'admin_user_headicon/2019-12/5df1deb52b642.jpg', 'b64543a98226cffcf90a9972bf014a90f703eaca.jpg', '1', '2', '1', '1576132277');
INSERT INTO `sky_sys_file` VALUES ('4', 'admin_user_headicon', '/mnt/share/hyperf-skeleton/public/upload/admin_user_headicon/2019-12/5df1df1344e4d.jpg', 'admin_user_headicon/2019-12/5df1df1344e4d.jpg', 'b64543a98226cffcf90a9972bf014a90f703eaca.jpg', '1', '2', '1', '1576132371');
INSERT INTO `sky_sys_file` VALUES ('5', 'admin_user_headicon', '/mnt/share/hyperf-skeleton/public/upload/admin_user_headicon/2019-12/5df1e4c787cf5.jpg', 'admin_user_headicon/2019-12/5df1e4c787cf5.jpg', 'qrcode_for_gh_48b9047b2fda_258.jpg', '1', '2', '1', '1576133831');
INSERT INTO `sky_sys_file` VALUES ('6', 'admin_user_headicon', '/mnt/share/hyperf-skeleton/public/upload/admin_user_headicon/2019-12/5df1e634bb44b.jpg', 'admin_user_headicon/2019-12/5df1e634bb44b.jpg', 'qrcode_for_gh_48b9047b2fda_258.jpg', '1', '2', '1', '1576134196');
INSERT INTO `sky_sys_file` VALUES ('7', 'admin_user_headicon', '/mnt/share/hyperf-skeleton/public/upload/admin_user_headicon/2019-12/5df1e67aecad2.png', 'admin_user_headicon/2019-12/5df1e67aecad2.png', 'wallpaper_dandelion.png', '1', '2', '1', '1576134267');
