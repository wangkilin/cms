-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:26
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `zhiwen`
-- 

CREATE TABLE `zhiwen` (
  `id` int(11) NOT NULL auto_increment,
  `zhiwen` varchar(50) default NULL,
  `jiexi` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `zhiwen` (`zhiwen`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- 
-- 导出表中的数据 `zhiwen`
-- 

INSERT INTO `zhiwen` VALUES (1, 'xxxxx', '温顺有能力，性格朴素，大方正直，有思想泼动，但能讲信用，保持威信。');
INSERT INTO `zhiwen` VALUES (2, 'xxxxo', '有毅力，机智灵敏。 但狡猾，好色，一般是贱人。');
INSERT INTO `zhiwen` VALUES (3, 'xxxox', '手巧聪明，但沉着性差，多感情。');
INSERT INTO `zhiwen` VALUES (4, 'xxxoo', '嘴甜，感情为重，活泼，后果不佳。');
INSERT INTO `zhiwen` VALUES (5, 'xxoxx', '较稳重，说话太多，但办事认真。 固执己见，往往多折。');
INSERT INTO `zhiwen` VALUES (6, 'xxoxo', '生性粗鲁，好大吹大擂，性情狂热。');
INSERT INTO `zhiwen` VALUES (7, 'xxoox', '有钻研的性格，多愁善感。');
INSERT INTO `zhiwen` VALUES (8, 'xxooo', '感情丰富，有计划，有活泼能力，办事有思考。');
INSERT INTO `zhiwen` VALUES (9, 'xoxxx', '表面是温顺，其实骄傲，但有运气。');
INSERT INTO `zhiwen` VALUES (10, 'xoxxo', '冷酷无情，有活动能力，但外表热情。');
INSERT INTO `zhiwen` VALUES (11, 'xoxox', '有计划，通情达理，有活动能力，办事彻底。');
INSERT INTO `zhiwen` VALUES (12, 'xoxoo', '稳重，有活动能力，官气十足，激于色情。');
INSERT INTO `zhiwen` VALUES (13, 'xooxx', '待人接物热情，却有神精质，办事欠思考。');
INSERT INTO `zhiwen` VALUES (14, 'xooxo', '爱好文艺，温顺大方，办事认真，但遇事忧豫不决。爱好文艺，温顺大方，办事认真，但遇事忧豫不决。');
INSERT INTO `zhiwen` VALUES (15, 'xooox', '感情强烈活波，不甘落后，有自尊心，能干，但不协调周全。');
INSERT INTO `zhiwen` VALUES (16, 'xoooo', '能说能干，性情稳重，自尊心强。');
INSERT INTO `zhiwen` VALUES (17, 'oxxxx', '性情温和，善于诱人，为人热情，固执己见。');
INSERT INTO `zhiwen` VALUES (18, 'oxxxo', '诡辩，吹牛求疵，自已为是，不听旁人劝告。');
INSERT INTO `zhiwen` VALUES (19, 'oxxox', '易被利用，理智顽固，感情误事，结果不怎么好。');
INSERT INTO `zhiwen` VALUES (20, 'oxxoo', '接受能力强，好动感情，宁愿助人为乐。');
INSERT INTO `zhiwen` VALUES (21, 'oxoxx', '办事漂亮，却心情不定，经不起色情考验。');
INSERT INTO `zhiwen` VALUES (22, 'oxoxo', '感情丰富，有活动能力，感情用事，顾自己。');
INSERT INTO `zhiwen` VALUES (23, 'oxoox', '感情好动，肯钻研，才智过人，通情达理。');
INSERT INTO `zhiwen` VALUES (24, 'oxooo', '脑忆力强，个性强，运气好。');
INSERT INTO `zhiwen` VALUES (25, 'ooxxx', '求知欲望强，办事协调，文雅好奇。');
INSERT INTO `zhiwen` VALUES (26, 'ooxxo', '自私有信念，不听人劝告，善感，多挫折。');
INSERT INTO `zhiwen` VALUES (27, 'ooxox', '日日多友，感情深厚，性情开郎。');
INSERT INTO `zhiwen` VALUES (28, 'ooxoo', '手巧，有活动能力，爱清洁，表面悠闲，实际内心复杂。');
INSERT INTO `zhiwen` VALUES (29, 'oooxx', '信念坚强，好外表，但实际能力差，没毅力，办事虎头蛇尾，不能果断，不彻底。');
INSERT INTO `zhiwen` VALUES (30, 'oooxo', '社会经验丰富，性格开郎，灵活，有活动能力。');
INSERT INTO `zhiwen` VALUES (31, 'oooox', '稳重有主张，早年生活奔波，遇难不死，晚年好。');
INSERT INTO `zhiwen` VALUES (32, 'ooooo', '有信念，办事积极认真努力，能创造，讲究发明，经常体壮，不听人意见。');
