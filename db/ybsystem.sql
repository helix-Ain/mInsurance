/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : ybsystem

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-08-28 09:51:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码 MD5加密',
  `salt` varchar(16) DEFAULT NULL COMMENT '盐值',
  `permission` tinyint(4) NOT NULL DEFAULT '0' COMMENT '权限',
  `logintime` int(11) DEFAULT '0',
  `loginip` varchar(15) DEFAULT '',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '352b80da9d0cb559d2e5b4edbbd83b60', '1234', '0', '1472314553', '::1', '2016-04-10 02:07:12');

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `classid` varchar(10) NOT NULL,
  `schoolid` int(11) DEFAULT NULL COMMENT '学院ID',
  `majorid` int(11) DEFAULT NULL COMMENT '专业ID',
  PRIMARY KEY (`classid`),
  KEY `schoolid` (`schoolid`),
  KEY `majorid` (`majorid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('130803', '11', '7');

-- ----------------------------
-- Table structure for major
-- ----------------------------
DROP TABLE IF EXISTS `major`;
CREATE TABLE `major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '专业名',
  `schoolid` int(11) DEFAULT NULL COMMENT '学院ID',
  PRIMARY KEY (`id`),
  KEY `schoolid` (`schoolid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of major
-- ----------------------------
INSERT INTO `major` VALUES ('7', '软件工程', '11');

-- ----------------------------
-- Table structure for scholarship_gainer
-- ----------------------------
DROP TABLE IF EXISTS `scholarship_gainer`;
CREATE TABLE `scholarship_gainer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stuid` varchar(10) NOT NULL,
  `termid` int(11) NOT NULL DEFAULT '0',
  `levelid` int(11) DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of scholarship_gainer
-- ----------------------------
INSERT INTO `scholarship_gainer` VALUES ('12', '3113002410', '19', '5');

-- ----------------------------
-- Table structure for scholarship_level
-- ----------------------------
DROP TABLE IF EXISTS `scholarship_level`;
CREATE TABLE `scholarship_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `levelname` varchar(30) NOT NULL DEFAULT '',
  `money` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of scholarship_level
-- ----------------------------
INSERT INTO `scholarship_level` VALUES ('5', '国家励志奖学金', '10000', '无');
INSERT INTO `scholarship_level` VALUES ('6', '吕志和奖学金', '1000', '无');

-- ----------------------------
-- Table structure for scholarship_term
-- ----------------------------
DROP TABLE IF EXISTS `scholarship_term`;
CREATE TABLE `scholarship_term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `starttime` timestamp NOT NULL,
  `endtime` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of scholarship_term
-- ----------------------------
INSERT INTO `scholarship_term` VALUES ('19', '2016年上半学期', '2016-08-27 00:00:00', '2017-02-18 00:00:00', '1');

-- ----------------------------
-- Table structure for school
-- ----------------------------
DROP TABLE IF EXISTS `school`;
CREATE TABLE `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '学院名',
  `telephone` varchar(12) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of school
-- ----------------------------
INSERT INTO `school` VALUES ('11', '计算机学院', '18814182439', 'IT');

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `stuid` varchar(10) NOT NULL COMMENT '学号',
  `name` varchar(20) DEFAULT NULL COMMENT '姓名',
  `identification` varchar(18) DEFAULT NULL COMMENT '身份证号',
  `sex` varchar(3) DEFAULT NULL COMMENT '性别 0女1男',
  `birthday` date DEFAULT NULL COMMENT '生日 YYYY-MM-DD',
  `note` varchar(300) DEFAULT NULL COMMENT '备注',
  `classid` varchar(10) DEFAULT NULL COMMENT '班级',
  `major` varchar(60) DEFAULT '' COMMENT '专业',
  `school` varchar(60) DEFAULT '' COMMENT '学院',
  `insured` tinyint(4) DEFAULT '-1' COMMENT '参保情况 -1未定义 0不参保 1参保',
  PRIMARY KEY (`stuid`),
  KEY `classid` (`classid`),
  KEY `majorid` (`major`),
  KEY `schoolid` (`school`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('3113002410', '许光杰', '442000199310222034', '男', '2016-08-18', '', '130803', '软件工程', '计算机学院', '1');

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码 MD5加密',
  `salt` varchar(16) DEFAULT '' COMMENT '盐值',
  `operator` varchar(20) DEFAULT '' COMMENT '操作员',
  `description` varchar(255) DEFAULT '' COMMENT '简介',
  `schoolid` int(11) DEFAULT NULL COMMENT '学院ID',
  `logintime` int(11) DEFAULT '0' COMMENT '最后登陆时间',
  `loginip` varchar(15) DEFAULT '' COMMENT '最后登陆IP',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `schoolid` (`schoolid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES ('6', 'Ain', 'a66e6a2e7657197b90d4211abb84cb57', '15117', '许光杰', '123456', '11', '0', '', '2016-08-27 01:36:23');

-- ----------------------------
-- View structure for v_scholarship_gainer_level
-- ----------------------------
DROP VIEW IF EXISTS `v_scholarship_gainer_level`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`127.0.0.1` SQL SECURITY DEFINER  VIEW `v_scholarship_gainer_level` AS SELECT
scholarship_gainer.id,
scholarship_gainer.stuid,
scholarship_gainer.termid,
scholarship_gainer.levelid,
scholarship_level.levelname,
scholarship_level.money
FROM
scholarship_gainer ,
scholarship_level
WHERE
scholarship_gainer.levelid = scholarship_level.id ;
