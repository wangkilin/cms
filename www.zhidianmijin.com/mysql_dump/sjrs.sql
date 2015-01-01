-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:22
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `sjrs`
-- 

CREATE TABLE `sjrs` (
  `id` int(11) NOT NULL auto_increment,
  `wh` varchar(50) default NULL,
  `sj` varchar(50) default NULL,
  `sjrs` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- 
-- 导出表中的数据 `sjrs`
-- 

INSERT INTO `sjrs` VALUES (1, '水', '秋', '必须有金相助，忌土、金、水多，喜木、火');
INSERT INTO `sjrs` VALUES (2, '金', '冬', '必须有火、土相助，忌无火、土反而有金、水，忌木多而无火');
INSERT INTO `sjrs` VALUES (3, '金', '春', '喜有土、火，最忌没有土、金');
INSERT INTO `sjrs` VALUES (4, '金', '夏', '必须有水相助，忌木多');
INSERT INTO `sjrs` VALUES (5, '金', '秋', '喜有木、火，忌土多');
INSERT INTO `sjrs` VALUES (6, '土', '秋', '喜有火，有木，忌金、水多');
INSERT INTO `sjrs` VALUES (7, '木', '秋', '必须有金相助，但忌金太多，须有土、火才好，但忌水多');
INSERT INTO `sjrs` VALUES (8, '火', '秋', '喜有木，忌水、土多');
INSERT INTO `sjrs` VALUES (9, '火', '春', '此时必为丙火或丁火，大都不错，但忌木多、土多');
INSERT INTO `sjrs` VALUES (10, '土', '春', '喜有火、木，喜有金而少，忌金多、木多');
INSERT INTO `sjrs` VALUES (11, '水', '春', '必须有土相助，若有火，金，但忌金多');
INSERT INTO `sjrs` VALUES (12, '木', '春', '必须有火助，有水更好，但忌水太多，也忌土太多');
INSERT INTO `sjrs` VALUES (13, '木', '冬', '必须有火相助，最好有土、水');
INSERT INTO `sjrs` VALUES (14, '火', '冬', '必须有木相助，忌有水与金多，喜有土、水、木');
INSERT INTO `sjrs` VALUES (15, '土', '冬', '喜有火，更喜有火又有金，喜有土、木');
INSERT INTO `sjrs` VALUES (16, '水', '冬', '必须有火相助，喜水多，但忌金多');
INSERT INTO `sjrs` VALUES (17, '水', '夏', '必须有金相助，忌木多');
INSERT INTO `sjrs` VALUES (18, '火', '夏', '必须有水相助，最喜有金');
INSERT INTO `sjrs` VALUES (19, '木', '夏', '必须有水相助，忌土太多，也忌木太多');
INSERT INTO `sjrs` VALUES (20, '土', '夏', '喜有水、金，忌有木');
