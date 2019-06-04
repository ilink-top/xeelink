/*
 Navicat Premium Data Transfer

 Source Server         : _localhost
 Source Server Type    : MySQL
 Source Server Version : 50721
 Source Host           : 127.0.0.1:3306
 Source Schema         : libra_admin

 Target Server Type    : MySQL
 Target Server Version : 50721
 File Encoding         : 65001

 Date: 22/05/2019 13:22:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lib_admin
-- ----------------------------
DROP TABLE IF EXISTS `lib_admin`;
CREATE TABLE `lib_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(60) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `create_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of lib_admin
-- ----------------------------
BEGIN;
INSERT INTO `lib_admin` VALUES (1, 'admin', '$2y$10$4B.qM1AMC0LUgHcsNbJUyeVPCO.vE9R3PDnmKI5Tk.J2ctbBi7Vm.', 'admin', '', 0, 1558492648, 0, 1556508911, 1558492648);
COMMIT;

-- ----------------------------
-- Table structure for lib_admin_auth
-- ----------------------------
DROP TABLE IF EXISTS `lib_admin_auth`;
CREATE TABLE `lib_admin_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0:禁用;1:启用;',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for lib_admin_auth_access
-- ----------------------------
DROP TABLE IF EXISTS `lib_admin_auth_access`;
CREATE TABLE `lib_admin_auth_access` (
  `auth_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for lib_admin_auth_menu
-- ----------------------------
DROP TABLE IF EXISTS `lib_admin_auth_menu`;
CREATE TABLE `lib_admin_auth_menu` (
  `auth_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限ID',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT '菜单ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for lib_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `lib_admin_log`;
CREATE TABLE `lib_admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '行为名称',
  `url` varchar(80) NOT NULL DEFAULT '' COMMENT '操作链接',
  `ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '操作IP',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for lib_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `lib_admin_menu`;
CREATE TABLE `lib_admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `url` varchar(80) NOT NULL DEFAULT '' COMMENT '链接',
  `icon` varchar(20) NOT NULL DEFAULT '' COMMENT '图标',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '可见：0:隐藏;1:显示;',
  `type` int(3) NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0:禁用;1:启用;',
  `condition` varchar(100) NOT NULL DEFAULT '' COMMENT '条件',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of lib_admin_menu
-- ----------------------------
BEGIN;
INSERT INTO `lib_admin_menu` VALUES (1, 0, '系统管理', '', 'fa-gears', 1, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (2, 1, '用户列表', 'admin/index', 'fa-circle-o', 1, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (3, 2, '添加用户', 'admin/add', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (4, 2, '编辑用户', 'admin/edit', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (5, 2, '删除用户', 'admin/delete', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (6, 2, '用户权限', 'admin/auth', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (7, 1, '权限列表', 'admin_auth/index', 'fa-circle-o', 1, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (8, 7, '添加权限', 'admin_auth/add', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (9, 7, '编辑权限', 'admin_auth/edit', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (10, 7, '删除权限', 'admin_auth/delete', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (11, 7, '权限菜单', 'admin_auth/menu', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (12, 1, '菜单列表', 'admin_menu/index', 'fa-circle-o', 1, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (13, 12, '添加菜单', 'admin_menu/add', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (14, 12, '编辑菜单', 'admin_menu/edit', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (15, 12, '删除菜单', 'admin_menu/delete', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (16, 1, '操作日志', 'admin_log/index', 'fa-circle-o', 1, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (17, 16, '删除日志', 'admin_log/delete', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (18, 1, '插件管理', 'system_plugin/index', 'fa-circle-o', 1, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (19, 18, '驱动列表', 'system_plugin/driver', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (20, 18, '安装驱动', 'system_plugin/add', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (21, 18, '设置驱动', 'system_plugin/edit', 'fa-circle-o', 0, 1, 1, '', 100);
INSERT INTO `lib_admin_menu` VALUES (22, 18, '卸载驱动', 'system_plugin/delete', 'fa-circle-o', 0, 1, 1, '', 100);
COMMIT;

-- ----------------------------
-- Table structure for lib_system_demo
-- ----------------------------
DROP TABLE IF EXISTS `lib_system_demo`;
CREATE TABLE `lib_system_demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0:禁用;1:启用;',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for lib_system_plugin
-- ----------------------------
DROP TABLE IF EXISTS `lib_system_plugin`;
CREATE TABLE `lib_system_plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(40) NOT NULL DEFAULT '' COMMENT '插件类型',
  `driver` varchar(20) NOT NULL DEFAULT '' COMMENT '插件驱动',
  `config` text NOT NULL COMMENT '插件配置',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0:禁用;1:启用;',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `unique_type_driver` (`type`,`driver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
