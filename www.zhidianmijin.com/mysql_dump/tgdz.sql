-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:23
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `tgdz`
-- 

CREATE TABLE `tgdz` (
  `id` int(11) NOT NULL auto_increment,
  `tg` varchar(50) default NULL,
  `dz` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- 导出表中的数据 `tgdz`
-- 

INSERT INTO `tgdz` VALUES (1, '甲', '子');
INSERT INTO `tgdz` VALUES (2, '乙', '丑');
INSERT INTO `tgdz` VALUES (3, '丙', '寅');
INSERT INTO `tgdz` VALUES (4, '丁', '卯');
INSERT INTO `tgdz` VALUES (5, '戊', '辰');
INSERT INTO `tgdz` VALUES (6, '己', '巳');
INSERT INTO `tgdz` VALUES (7, '庚', '午');
INSERT INTO `tgdz` VALUES (8, '辛', '未');
INSERT INTO `tgdz` VALUES (9, '壬', '申');
INSERT INTO `tgdz` VALUES (10, '癸', '酉');
INSERT INTO `tgdz` VALUES (11, '', '戌');
INSERT INTO `tgdz` VALUES (12, '', '亥');
