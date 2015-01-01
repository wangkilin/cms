-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:21
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `sbwr`
-- 

CREATE TABLE `sbwr` (
  `num` int(2) NOT NULL auto_increment,
  `intro` varchar(255) NOT NULL,
  PRIMARY KEY  (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- 导出表中的数据 `sbwr`
-- 

INSERT INTO `sbwr` VALUES (1, '皇宫贵族');
INSERT INTO `sbwr` VALUES (2, '非汉人（特征：有些方面的习惯会跟身边的人不太一样）');
INSERT INTO `sbwr` VALUES (3, '有钱人');
INSERT INTO `sbwr` VALUES (4, '读书人');
INSERT INTO `sbwr` VALUES (5, '武将');
INSERT INTO `sbwr` VALUES (6, '非人类');
INSERT INTO `sbwr` VALUES (7, '三级贫户');
INSERT INTO `sbwr` VALUES (8, '优（特征：肢体动作丰富，具表演天分）');
INSERT INTO `sbwr` VALUES (9, '出家人');
