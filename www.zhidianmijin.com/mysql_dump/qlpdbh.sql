-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:19
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `qlpdbh`
-- 

CREATE TABLE `qlpdbh` (
  `id` int(11) NOT NULL auto_increment,
  `bihua` varchar(255) default NULL,
  `intro` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- 
-- 导出表中的数据 `qlpdbh`
-- 

INSERT INTO `qlpdbh` VALUES (1, '1,16,56,61,85', '两人有默契　　');
INSERT INTO `qlpdbh` VALUES (2, '2,17,57,86', '他非常关心你　　');
INSERT INTO `qlpdbh` VALUES (3, '3,18,62,87', '你和他只能做朋友　　');
INSERT INTO `qlpdbh` VALUES (4, '4,19,32,58,88', '兴趣不合　　');
INSERT INTO `qlpdbh` VALUES (5, '5,35,63,89', '男生主动　　');
INSERT INTO `qlpdbh` VALUES (6, '6,41,59,90', '第三者介入　　');
INSERT INTO `qlpdbh` VALUES (7, '7,33,64,91', '他非常讨厌你　　');
INSERT INTO `qlpdbh` VALUES (8, '8,43,60,92', '早点分手比较好　　');
INSERT INTO `qlpdbh` VALUES (9, '9,47,66,70,93', '他有一堆女朋友　　');
INSERT INTO `qlpdbh` VALUES (10, '10,34,10,65,94', '两情相悦　　');
INSERT INTO `qlpdbh` VALUES (11, '11,46,73,11', '他对你献真情　　');
INSERT INTO `qlpdbh` VALUES (12, '12,42,55,74,96', '他已有心上人　　');
INSERT INTO `qlpdbh` VALUES (13, '13,36,49,69,97', '此情不渝　　');
INSERT INTO `qlpdbh` VALUES (14, '14,48,71,98', '他时常暗中注意你　　');
INSERT INTO `qlpdbh` VALUES (15, '15,37,72,99', '他有企图要小心　　');
INSERT INTO `qlpdbh` VALUES (16, '20,67,100', '他会爱你　　');
INSERT INTO `qlpdbh` VALUES (17, '17,21,38,75', '他非常在乎你　　');
INSERT INTO `qlpdbh` VALUES (18, '18,22,76', '女方主动　　');
INSERT INTO `qlpdbh` VALUES (19, '24,39,77', '也有人暗中注意你　　');
INSERT INTO `qlpdbh` VALUES (20, '25,40,78', '女方单恋　　');
INSERT INTO `qlpdbh` VALUES (21, '26,44,80', '不能长相厮守　　');
INSERT INTO `qlpdbh` VALUES (22, '27,50,81', '他会喜欢你　　');
INSERT INTO `qlpdbh` VALUES (23, '28,51,68,79', '要长期交往　　');
INSERT INTO `qlpdbh` VALUES (24, '29,52,82', '他早就爱上你　　');
INSERT INTO `qlpdbh` VALUES (25, '30,53,83', '他会抛弃你　　');
INSERT INTO `qlpdbh` VALUES (26, '31,54,84', '要互相沟通	');
