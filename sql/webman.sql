/*
 Navicat Premium Data Transfer

 Source Server         : 47
 Source Server Type    : MySQL
 Source Server Version : 50726 (5.7.26-log)
 Source Host           : 47.93.176.12:3306
 Source Schema         : webman

 Target Server Type    : MySQL
 Target Server Version : 50726 (5.7.26-log)
 File Encoding         : 65001

 Date: 04/11/2022 22:38:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for wb_admin
-- ----------------------------
DROP TABLE IF EXISTS `wb_admin`;
CREATE TABLE `wb_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(255) NOT NULL COMMENT '账号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `name` varchar(125) NOT NULL DEFAULT '' COMMENT '姓名',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:正常 0:禁用',
  `roles` varchar(255) NOT NULL DEFAULT '' COMMENT '角色',
  `last_ip` varchar(35) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

-- ----------------------------
-- Records of wb_admin
-- ----------------------------
BEGIN;
INSERT INTO `wb_admin` (`id`, `account`, `password`, `name`, `status`, `roles`, `last_ip`, `last_time`, `create_time`, `update_time`, `delete_time`) VALUES (1, 'admin', '###14e1b600b1fd579f47433b88e8d85291', 'admin', 1, '1', '223.94.193.126', 1667569316, 0, 1667569316, 0);
INSERT INTO `wb_admin` (`id`, `account`, `password`, `name`, `status`, `roles`, `last_ip`, `last_time`, `create_time`, `update_time`, `delete_time`) VALUES (2, 'test1', '###418d89a45edadb8ce4da17e07f72536c', '测试管理员', 1, '2', '127.0.0.1', 1667182701, 1667180778, 1667183868, 1667183868);
INSERT INTO `wb_admin` (`id`, `account`, `password`, `name`, `status`, `roles`, `last_ip`, `last_time`, `create_time`, `update_time`, `delete_time`) VALUES (3, 'test1', '###418d89a45edadb8ce4da17e07f72536c', '测试管理员', 1, '2', '', 0, 1667183889, 1667183889, 0);
INSERT INTO `wb_admin` (`id`, `account`, `password`, `name`, `status`, `roles`, `last_ip`, `last_time`, `create_time`, `update_time`, `delete_time`) VALUES (4, 'test2', '###4ff9018a647ae315a7e6601a818b4940', '测试2', 1, '2', '124.127.48.204', 1667197693, 1667197322, 1667197693, 0);
COMMIT;

-- ----------------------------
-- Table structure for wb_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `wb_admin_menu`;
CREATE TABLE `wb_admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `title` varchar(125) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(55) NOT NULL DEFAULT '' COMMENT '图标',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0:目录 1:菜单',
  `app` varchar(25) NOT NULL DEFAULT '',
  `controller` varchar(35) NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(35) NOT NULL DEFAULT '' COMMENT '方法',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:显示 0:不显示',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序 大->小',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of wb_admin_menu
-- ----------------------------
BEGIN;
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (1, 0, '系统管理', 'layui-icon-util', 0, 'admin', 'system', 'default', 1, 1000, 1667196422, 1667564007, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (2, 1, '系统设置', '', 1, 'admin', 'index', 'syssetting', 1, 0, 1667196422, 1667197300, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (3, 1, '菜单管理', '', 1, 'admin', 'menu', 'index', 1, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (4, 1, '角色管理', '', 1, 'admin', 'roles', 'index', 1, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (5, 1, '管理员管理', '', 1, 'admin', 'admin', 'index', 1, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (6, 3, '菜单列表', 'layui-icon-rate-solid', 1, 'admin', 'menu', 'getlist', 0, 0, 1667196422, 1667201591, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (7, 3, '菜单添加/编辑', '', 1, 'admin', 'menu', 'edit', 0, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (8, 3, '菜单删除', '', 1, 'admin', 'menu', 'del', 0, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (9, 4, '角色列表', '', 1, 'admin', 'roles', 'getlist', 0, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (10, 4, '角色添加/编辑', '', 1, 'admin', 'roles', 'edit', 0, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (11, 4, '角色删除', '', 1, 'admin', 'roles', 'del', 0, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (12, 5, '管理员列表', '', 1, 'admin', 'admin', 'getlist', 0, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (13, 5, '管理员添加/编辑', '', 1, 'admin', 'admin', 'edit', 0, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (14, 5, '管理员删除', '', 1, 'admin', 'admin', 'del', 0, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (15, 5, '修改状态', '', 1, 'admin', 'admin', 'updstatus', 0, 0, 1667196422, 1667196422, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (16, 1, '上传附件记录', '', 1, 'admin', 'index', 'uploadlist', 1, 0, 1667207500, 1667207500, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (17, 1, '请求记录', '', 1, 'admin', 'index', 'requestlog', 1, 0, 1667373403, 1667373403, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (18, 17, '获取记录数据', '', 1, 'admin', 'index', 'getrequestlog', 0, 0, 1667373638, 1667373638, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (19, 17, '清空请求记录', '', 1, 'admin', 'index', 'requestlogdel', 0, 0, 1667374846, 1667374846, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (20, 0, '用户管理', 'layui-icon-username', 0, 'admin', 'user', 'default', 1, 0, 1667571530, 1667571530, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (21, 20, '用户列表', '', 1, 'admin', 'user', 'index', 1, 0, 1667571574, 1667571574, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (22, 21, '获取用户列表数据', '', 1, 'admin', 'user', 'getlist', 0, 0, 1667571602, 1667571602, 0);
INSERT INTO `wb_admin_menu` (`id`, `pid`, `title`, `icon`, `type`, `app`, `controller`, `action`, `is_show`, `sort`, `create_time`, `update_time`, `delete_time`) VALUES (23, 21, '修改用户状态', '', 1, 'admin', 'user', 'updstatus', 0, 0, 1667572533, 1667572533, 0);
COMMIT;

-- ----------------------------
-- Table structure for wb_admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `wb_admin_roles`;
CREATE TABLE `wb_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '角色名',
  `rules` text COMMENT '权限',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
-- Records of wb_admin_roles
-- ----------------------------
BEGIN;
INSERT INTO `wb_admin_roles` (`id`, `name`, `rules`, `create_time`, `update_time`, `delete_time`) VALUES (1, '超级管理员', '*', 1667122851, 1667122851, 0);
INSERT INTO `wb_admin_roles` (`id`, `name`, `rules`, `create_time`, `update_time`, `delete_time`) VALUES (2, '菜单管理员', '1,3,6,7,8', 1667129336, 1667196723, 0);
COMMIT;

-- ----------------------------
-- Table structure for wb_option
-- ----------------------------
DROP TABLE IF EXISTS `wb_option`;
CREATE TABLE `wb_option` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(125) NOT NULL COMMENT '配置name',
  `option_value` text COMMENT '配置内容',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='配置表';

-- ----------------------------
-- Records of wb_option
-- ----------------------------
BEGIN;
INSERT INTO `wb_option` (`id`, `option_name`, `option_value`, `delete_time`) VALUES (1, 'site_info', '{\"title\":\"Webman Admin\",\"desc\":\"webman+pear \\u901a\\u7528\\u540e\\u53f0\\u7ba1\\u7406\"}', 0);
INSERT INTO `wb_option` (`id`, `option_name`, `option_value`, `delete_time`) VALUES (2, 'upload_info', '{\"type\":\"0\",\"extensions\":\"jpg,jpeg,png,gif,bmp4,mp4,avi,wmv,rm,rmvb,mkv,mp3,wma,wav,txt,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,csv\",\"maxsize\":\"10\",\"oss_endpoint\":\"123\",\"oss_bucket\":\"123\",\"oss_accessKeyId\":\"123\",\"oss_accessKeySecret\":\"123\",\"qiniu_bucketUrl\":\"123\",\"qiniu_bucket\":\"123\",\"qiniu_accessKey\":\"123\",\"qiniu_secretKey\":\"123\"}', 0);
COMMIT;

-- ----------------------------
-- Table structure for wb_request_log
-- ----------------------------
DROP TABLE IF EXISTS `wb_request_log`;
CREATE TABLE `wb_request_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(26) NOT NULL DEFAULT '',
  `method` varchar(15) NOT NULL DEFAULT '',
  `fullurl` varchar(255) NOT NULL DEFAULT '',
  `app` varchar(26) NOT NULL DEFAULT '',
  `controller` varchar(55) NOT NULL DEFAULT '',
  `action` varchar(55) NOT NULL DEFAULT '',
  `route` varchar(125) NOT NULL DEFAULT '' COMMENT '路由',
  `times` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '请求耗时 ms',
  `exception` varchar(555) NOT NULL DEFAULT '' COMMENT '异常数据',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1676 DEFAULT CHARSET=utf8mb4 COMMENT='请求记录表';

-- ----------------------------
-- Records of wb_request_log
-- ----------------------------
BEGIN;
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1657, '221.218.28.86', 'DELETE', 'wbadmin.itjiale.com/admin/index/requestlogdel?type=1', 'admin', 'IndexController', 'requestlogDel', '/admin/index/requestlogdel', 5, '', 1667572600);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1658, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/index/getrequestlog?page=2&limit=10', 'admin', 'IndexController', 'getRequestLog', '/admin/index/getrequestlog', 3, '', 1667572602);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1659, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/index/requestlog', 'admin', 'IndexController', 'requestlog', '/admin/index/requestlog', 3, '', 1667572603);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1660, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/index/getrequestlog?page=1&limit=10', 'admin', 'IndexController', 'getRequestLog', '/admin/index/getrequestlog', 4, '', 1667572603);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1661, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/index', 'admin', 'UserController', 'index', '/admin/user/index', 3, '', 1667572608);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1662, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 4, '', 1667572608);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1663, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10&mobile=123123', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 4, '', 1667572613);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1664, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10&mobile=123123', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 4, '', 1667572614);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1665, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10&mobile=111111', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 8, '', 1667572619);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1666, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/index', 'admin', 'UserController', 'index', '/admin/user/index', 17, '', 1667572622);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1667, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 4, '', 1667572622);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1668, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/index', 'admin', 'UserController', 'index', '/admin/user/index', 17, '', 1667572647);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1669, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 24, '', 1667572647);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1670, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10&mobile=123123', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 3, '', 1667572650);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1671, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10&mobile=176', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 5, '', 1667572653);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1672, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/index', 'admin', 'UserController', 'index', '/admin/user/index', 3, '', 1667572654);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1673, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 34, '', 1667572654);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1674, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/index', 'admin', 'UserController', 'index', '/admin/user/index', 3, '', 1667572657);
INSERT INTO `wb_request_log` (`id`, `ip`, `method`, `fullurl`, `app`, `controller`, `action`, `route`, `times`, `exception`, `create_time`) VALUES (1675, '221.218.28.86', 'GET', 'wbadmin.itjiale.com/admin/user/getlist?page=1&limit=10', 'admin', 'UserController', 'getlist', '/admin/user/getlist', 4, '', 1667572657);
COMMIT;

-- ----------------------------
-- Table structure for wb_upload_file
-- ----------------------------
DROP TABLE IF EXISTS `wb_upload_file`;
CREATE TABLE `wb_upload_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(150) NOT NULL DEFAULT '',
  `origin_name` varchar(255) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `save_name` varchar(255) NOT NULL DEFAULT '' COMMENT '保存文件名',
  `save_path` varchar(255) NOT NULL DEFAULT '' COMMENT '保存的绝对路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '访问路径',
  `unique_id` varchar(255) NOT NULL DEFAULT '' COMMENT '唯一id',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '大小(字节)',
  `mime_type` varchar(50) NOT NULL DEFAULT '' COMMENT '类型',
  `extension` varchar(30) NOT NULL DEFAULT '' COMMENT '后缀',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='文件上传记录表';

-- ----------------------------
-- Records of wb_upload_file
-- ----------------------------
BEGIN;
INSERT INTO `wb_upload_file` (`id`, `key`, `origin_name`, `save_name`, `save_path`, `url`, `unique_id`, `size`, `mime_type`, `extension`, `create_time`, `update_time`, `delete_time`) VALUES (1, 'file1', '885cb0a0d3aa01ad.jpg', 'ce831672e515c0ddb489a33b4594bba6e638e95d.jpg', '/www/webman/webman/public/upload/20221101/ce831672e515c0ddb489a33b4594bba6e638e95d.jpg', 'http://wbadmin.itjiale.com/upload/20221101/ce831672e515c0ddb489a33b4594bba6e638e95d.jpg', 'ce831672e515c0ddb489a33b4594bba6e638e95d', 15651, 'image/jpeg', 'jpg', 1667262741, 1667262741, 0);
INSERT INTO `wb_upload_file` (`id`, `key`, `origin_name`, `save_name`, `save_path`, `url`, `unique_id`, `size`, `mime_type`, `extension`, `create_time`, `update_time`, `delete_time`) VALUES (2, 'file', 'WechatIMG41.png', '6abd723eb4403cea04dcd187165568a8b7f671c1.png', '/www/webman/webman/public/upload/20221104/6abd723eb4403cea04dcd187165568a8b7f671c1.png', 'http://wbadmin.itjiale.com/upload/20221104/6abd723eb4403cea04dcd187165568a8b7f671c1.png', '6abd723eb4403cea04dcd187165568a8b7f671c1', 16690, 'image/png', 'png', 1667571984, 1667571984, 0);
COMMIT;

-- ----------------------------
-- Table structure for wb_user
-- ----------------------------
DROP TABLE IF EXISTS `wb_user`;
CREATE TABLE `wb_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(30) NOT NULL DEFAULT '' COMMENT '中国手机号不带前缀，其他手机号前缀-手机号',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1:正常 0:禁用',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后登陆ip',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
-- Records of wb_user
-- ----------------------------
BEGIN;
INSERT INTO `wb_user` (`id`, `mobile`, `password`, `nickname`, `avatar`, `balance`, `status`, `last_login_ip`, `last_login_time`, `create_time`, `update_time`, `delete_time`) VALUES (1, '17600639999', '###14e1b600b1fd579f47433b88e8d85291', '', '', 0.00, 1, '221.218.28.86', 1667570661, 1667562846, 1667570661, 0);
INSERT INTO `wb_user` (`id`, `mobile`, `password`, `nickname`, `avatar`, `balance`, `status`, `last_login_ip`, `last_login_time`, `create_time`, `update_time`, `delete_time`) VALUES (2, '17600639991', '###14e1b600b1fd579f47433b88e8d85291', '', '', 0.00, 1, '221.218.28.86', 1667570833, 1667570833, 1667570833, 0);
COMMIT;

-- ----------------------------
-- Table structure for wb_verification_code
-- ----------------------------
DROP TABLE IF EXISTS `wb_verification_code`;
CREATE TABLE `wb_verification_code` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(30) NOT NULL COMMENT '手机号',
  `code` varchar(10) NOT NULL COMMENT '验证码',
  `type` varchar(15) NOT NULL COMMENT '验证码类型:register注册，可扩展',
  `expire_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `delete_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='验证码记录表,验证后软删除数据';

-- ----------------------------
-- Records of wb_verification_code
-- ----------------------------
BEGIN;
INSERT INTO `wb_verification_code` (`id`, `mobile`, `code`, `type`, `expire_time`, `create_time`, `update_time`, `delete_time`) VALUES (1, '17600639999', '4194', 'register', 0, 1667567412, 1667567412, 0);
INSERT INTO `wb_verification_code` (`id`, `mobile`, `code`, `type`, `expire_time`, `create_time`, `update_time`, `delete_time`) VALUES (2, '17600639999', '6036', 'register', 1667578049, 1667567449, 1667567449, 0);
INSERT INTO `wb_verification_code` (`id`, `mobile`, `code`, `type`, `expire_time`, `create_time`, `update_time`, `delete_time`) VALUES (3, '17600639999', '2000', 'register', 1767568886, 1767568286, 1667569786, 1667569786);
INSERT INTO `wb_verification_code` (`id`, `mobile`, `code`, `type`, `expire_time`, `create_time`, `update_time`, `delete_time`) VALUES (4, '17600639999', '3313', 'register', 1667570721, 1667570121, 1667570121, 0);
INSERT INTO `wb_verification_code` (`id`, `mobile`, `code`, `type`, `expire_time`, `create_time`, `update_time`, `delete_time`) VALUES (5, '17600639991', '3214', 'register', 1667571418, 1667570818, 1667570833, 1667570833);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
