-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:17
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `jmlb`
-- 

CREATE TABLE `jmlb` (
  `id` int(11) NOT NULL auto_increment,
  `jmlb` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- 导出表中的数据 `jmlb`
-- 

INSERT INTO `jmlb` VALUES (1, '人 物');
INSERT INTO `jmlb` VALUES (2, '情 爱');
INSERT INTO `jmlb` VALUES (3, '生 活');
INSERT INTO `jmlb` VALUES (4, '物 品');
INSERT INTO `jmlb` VALUES (5, '身 体');
INSERT INTO `jmlb` VALUES (6, '动植物');
INSERT INTO `jmlb` VALUES (7, '鬼 神');
INSERT INTO `jmlb` VALUES (8, '建 筑');
INSERT INTO `jmlb` VALUES (9, '自 然');
