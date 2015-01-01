-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:20
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `sanshishu`
-- 

CREATE TABLE `sanshishu` (
  `id` int(11) NOT NULL auto_increment,
  `nn` varchar(50) default NULL,
  `1` varchar(50) default NULL,
  `2` varchar(50) default NULL,
  `3` varchar(50) default NULL,
  `4` varchar(50) default NULL,
  `5` varchar(50) default NULL,
  `6` varchar(50) default NULL,
  `7` varchar(50) default NULL,
  `8` varchar(50) default NULL,
  `9` varchar(50) default NULL,
  `10` varchar(50) default NULL,
  `11` varchar(50) default NULL,
  `12` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- 导出表中的数据 `sanshishu`
-- 

INSERT INTO `sanshishu` VALUES (1, '0', '正', '逐', '背', '耗', '困', '天', '向', '煞', '才', '旺', '暗', '病');
INSERT INTO `sanshishu` VALUES (2, '1', '病', '正', '逐', '背', '耗', '困', '天', '向', '煞', '才', '旺', '暗');
INSERT INTO `sanshishu` VALUES (3, '2', '暗', '病', '正', '逐', '背', '耗', '困', '天', '向', '煞', '才', '旺');
INSERT INTO `sanshishu` VALUES (4, '3', '旺', '暗', '病', '正', '逐', '背', '耗', '困', '天', '向', '煞', '才');
INSERT INTO `sanshishu` VALUES (5, '4', '向', '煞', '才', '旺', '暗', '病', '正', '逐', '背', '耗', '困', '天');
INSERT INTO `sanshishu` VALUES (6, '5', '天', '向', '煞', '才', '旺', '暗', '病', '正', '逐', '背', '耗', '困');
INSERT INTO `sanshishu` VALUES (7, '6', '困', '天', '向', '煞', '才', '旺', '暗', '病', '正', '逐', '背', '耗');
INSERT INTO `sanshishu` VALUES (8, '7', '耗', '困', '天', '向', '煞', '才', '旺', '暗', '病', '正', '逐', '背');
INSERT INTO `sanshishu` VALUES (9, '8', '背', '耗', '困', '天', '向', '煞', '才', '旺', '暗', '病', '正', '逐');
INSERT INTO `sanshishu` VALUES (10, '9', '逐', '背', '耗', '困', '天', '向', '煞', '才', '旺', '暗', '病', '正');
