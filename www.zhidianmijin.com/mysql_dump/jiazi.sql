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
-- 表的结构 `jiazi`
-- 

CREATE TABLE `jiazi` (
  `id` int(11) NOT NULL auto_increment,
  `jiazi` varchar(50) default NULL,
  `layin` varchar(50) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

-- 
-- 导出表中的数据 `jiazi`
-- 

INSERT INTO `jiazi` VALUES (1, '甲子', '海中金');
INSERT INTO `jiazi` VALUES (2, '乙丑', '海中金');
INSERT INTO `jiazi` VALUES (3, '丙寅', '炉中火');
INSERT INTO `jiazi` VALUES (4, '丁卯', '炉中火');
INSERT INTO `jiazi` VALUES (5, '戊辰', '大林木');
INSERT INTO `jiazi` VALUES (6, '己巳', '大林木');
INSERT INTO `jiazi` VALUES (7, '庚午', '路旁土');
INSERT INTO `jiazi` VALUES (8, '辛未', '路旁土');
INSERT INTO `jiazi` VALUES (9, '壬申', '剑锋金');
INSERT INTO `jiazi` VALUES (10, '癸酉', '剑锋金');
INSERT INTO `jiazi` VALUES (11, '甲戌', '山头火');
INSERT INTO `jiazi` VALUES (12, '乙亥', '山头火');
INSERT INTO `jiazi` VALUES (13, '丙子', '洞下水');
INSERT INTO `jiazi` VALUES (14, '丁丑', '洞下水');
INSERT INTO `jiazi` VALUES (15, '戊寅', '城墙土');
INSERT INTO `jiazi` VALUES (16, '己卯', '城墙土');
INSERT INTO `jiazi` VALUES (17, '庚辰', '白腊金');
INSERT INTO `jiazi` VALUES (18, '辛巳', '白腊金');
INSERT INTO `jiazi` VALUES (19, '壬午', '杨柳木');
INSERT INTO `jiazi` VALUES (20, '癸未', '杨柳木');
INSERT INTO `jiazi` VALUES (21, '甲申', '泉中水');
INSERT INTO `jiazi` VALUES (22, '乙酉', '泉中水');
INSERT INTO `jiazi` VALUES (23, '丙戌', '屋上土');
INSERT INTO `jiazi` VALUES (24, '丁亥', '屋上土');
INSERT INTO `jiazi` VALUES (25, '戊子', '霹雷火');
INSERT INTO `jiazi` VALUES (26, '己丑', '霹雷火');
INSERT INTO `jiazi` VALUES (27, '庚寅', '松柏木');
INSERT INTO `jiazi` VALUES (28, '辛卯', '松柏木');
INSERT INTO `jiazi` VALUES (29, '壬辰', '常流水');
INSERT INTO `jiazi` VALUES (30, '癸巳', '常流水');
INSERT INTO `jiazi` VALUES (31, '甲午', '沙中金');
INSERT INTO `jiazi` VALUES (32, '乙未', '沙中金');
INSERT INTO `jiazi` VALUES (33, '丙申', '山下火');
INSERT INTO `jiazi` VALUES (34, '丁酉', '山下火');
INSERT INTO `jiazi` VALUES (35, '戊戌', '平地木');
INSERT INTO `jiazi` VALUES (36, '己亥', '平地木');
INSERT INTO `jiazi` VALUES (37, '庚子', '壁上土');
INSERT INTO `jiazi` VALUES (38, '辛丑', '壁上土');
INSERT INTO `jiazi` VALUES (39, '壬寅', '金箔金');
INSERT INTO `jiazi` VALUES (40, '癸卯', '金箔金');
INSERT INTO `jiazi` VALUES (41, '甲辰', '佛灯火');
INSERT INTO `jiazi` VALUES (42, '乙巳', '佛灯火');
INSERT INTO `jiazi` VALUES (43, '丙午', '天河水');
INSERT INTO `jiazi` VALUES (44, '丁未', '天河水');
INSERT INTO `jiazi` VALUES (45, '戊申', '大驿土');
INSERT INTO `jiazi` VALUES (46, '己酉', '大驿土');
INSERT INTO `jiazi` VALUES (47, '庚戌', '钗钏金');
INSERT INTO `jiazi` VALUES (48, '辛亥', '钗钏金');
INSERT INTO `jiazi` VALUES (49, '壬子', '桑松木');
INSERT INTO `jiazi` VALUES (50, '癸丑', '桑松木');
INSERT INTO `jiazi` VALUES (51, '甲寅', '大溪水');
INSERT INTO `jiazi` VALUES (52, '乙卯', '大溪水');
INSERT INTO `jiazi` VALUES (53, '丙辰', '沙中土');
INSERT INTO `jiazi` VALUES (54, '丁巳', '沙中土');
INSERT INTO `jiazi` VALUES (55, '戊午', '天上火');
INSERT INTO `jiazi` VALUES (56, '己未', '天上火');
INSERT INTO `jiazi` VALUES (57, '庚申', '石榴木');
INSERT INTO `jiazi` VALUES (58, '辛酉', '石榴木');
INSERT INTO `jiazi` VALUES (59, '壬戌', '大海水');
INSERT INTO `jiazi` VALUES (60, '癸亥', '大海水');
