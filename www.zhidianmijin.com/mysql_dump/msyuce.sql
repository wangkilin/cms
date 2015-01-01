-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:18
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `msyuce`
-- 

CREATE TABLE `msyuce` (
  `id` int(11) NOT NULL auto_increment,
  `lb` varchar(50) default NULL,
  `stime` varchar(50) NOT NULL,
  `fx` varchar(50) default NULL,
  `content` longtext,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

-- 
-- 导出表中的数据 `msyuce`
-- 

INSERT INTO `msyuce` VALUES (1, '耳鸣', '1', '左', '左耳鸣是有异性惦记你哦，发个祝福的短消息给她。 ');
INSERT INTO `msyuce` VALUES (2, '耳鸣', '2', '左', '左耳鸣会破财，古人言：失之东隅，收之桑榆。 ');
INSERT INTO `msyuce` VALUES (3, '耳鸣', '3', '左', '左耳鸣会有饮食之意，少吃一点，别暴殄天物。');
INSERT INTO `msyuce` VALUES (4, '耳鸣', '4', '左', '左耳鸣会远行，长途跋涉，多准备点物品。');
INSERT INTO `msyuce` VALUES (5, '耳鸣', '5', '左', '左耳鸣今日凶多吉少，去危就安。 ');
INSERT INTO `msyuce` VALUES (6, '耳鸣', '6', '左', '左耳鸣是有异性惦记你哦，发个祝福的短消息给她。 ');
INSERT INTO `msyuce` VALUES (7, '耳鸣', '7', '左', '左耳鸣有口舌之争，能忍则忍，宰相肚里能撑船嘛。 ');
INSERT INTO `msyuce` VALUES (8, '耳鸣', '8', '左', '左耳鸣有人会请你饮食，尽管吃，过了这村没那店。');
INSERT INTO `msyuce` VALUES (9, '耳鸣', '9', '左', '左耳鸣你所关心之人会远行归回。 ');
INSERT INTO `msyuce` VALUES (10, '耳鸣', '10', '左', '左耳鸣会失财，就算救困扶危吧。 ');
INSERT INTO `msyuce` VALUES (11, '耳鸣', '11', '左', '左耳鸣会有饮食，少吃一点，身材要紧。 ');
INSERT INTO `msyuce` VALUES (12, '耳鸣', '12', '左', '左耳鸣大吉大利，万事亨通。 ');
INSERT INTO `msyuce` VALUES (13, '耳鸣', '1', '右', '右耳鸣会失财，常言道破财消灾。');
INSERT INTO `msyuce` VALUES (14, '耳鸣', '2', '右', '右耳鸣定有心急之事，明天在定夺也不迟，此时该休息了。 ');
INSERT INTO `msyuce` VALUES (15, '耳鸣', '3', '右', '右耳鸣会有贵宾光临。 ');
INSERT INTO `msyuce` VALUES (16, '耳鸣', '4', '右', '右耳鸣会有贵宾光临。 ');
INSERT INTO `msyuce` VALUES (17, '耳鸣', '5', '右', '左耳鸣今日凶多吉少，去危就安。 ');
INSERT INTO `msyuce` VALUES (18, '耳鸣', '6', '右', '右耳鸣有亲人来访，要盛情款待。 ');
INSERT INTO `msyuce` VALUES (19, '耳鸣', '7', '右', '右耳鸣有争辩诉讼，万事以和为贵。');
INSERT INTO `msyuce` VALUES (20, '耳鸣', '8', '右', '右耳鸣有客会来，叙叙旧吧。 ');
INSERT INTO `msyuce` VALUES (21, '耳鸣', '9', '右', '右耳鸣有喜事，喜从天降，别乐坏了！');
INSERT INTO `msyuce` VALUES (22, '耳鸣', '10', '右', '右耳鸣大吉大利，万事亨通。 ');
INSERT INTO `msyuce` VALUES (23, '耳鸣', '11', '右', '右耳鸣有贵宾光临。 ');
INSERT INTO `msyuce` VALUES (24, '耳鸣', '12', '右', '右耳鸣会有任请你吃夜宵，吃完了别忘记打包。');
INSERT INTO `msyuce` VALUES (25, '面热', '1', '', '有喜财天降，别乐坏了。 ');
INSERT INTO `msyuce` VALUES (26, '面热', '2', '', '有烦恼忧虑之事，找人倾诉倾诉吧！ ');
INSERT INTO `msyuce` VALUES (27, '面热', '3', '', '有远客来相聚，诸事顺利大吉。');
INSERT INTO `msyuce` VALUES (28, '面热', '4', '', '有友人来邀请饮食。');
INSERT INTO `msyuce` VALUES (29, '面热', '5', '', '远客、喜事会相临。');
INSERT INTO `msyuce` VALUES (30, '面热', '6', '', '大吉大利，万事亨通。 ');
INSERT INTO `msyuce` VALUES (31, '面热', '7', '', '有亲人相见，诸事大吉。 ');
INSERT INTO `msyuce` VALUES (32, '面热', '8', '', '有口舌与诉讼之争，万事谦让一点。 ');
INSERT INTO `msyuce` VALUES (33, '面热', '9', '', '有贵人会见，千万别冷落了他/她！ ');
INSERT INTO `msyuce` VALUES (34, '面热', '10', '', '有远客光临，相会大吉。 ');
INSERT INTO `msyuce` VALUES (35, '面热', '11', '', '有情人相约请客，别吃撑了，身体要紧。');
INSERT INTO `msyuce` VALUES (36, '面热', '12', '', '会有官司与讼事之事，谨慎为妙。 ');
INSERT INTO `msyuce` VALUES (37, '眼跳', '1', '左', '左眼跳是有贵人相助，何乐而不为。 ');
INSERT INTO `msyuce` VALUES (38, '眼跳', '2', '左', '左眼跳有烦恼之事，不妨找朋友倾诉一下。 ');
INSERT INTO `msyuce` VALUES (39, '眼跳', '3', '左', '左眼跳是有朋至远方来，好好款待他吧！ ');
INSERT INTO `msyuce` VALUES (40, '眼跳', '4', '左', '左眼跳有贵人来访，勿要怠慢了他，切记切记。 ');
INSERT INTO `msyuce` VALUES (41, '眼跳', '5', '左', '左眼跳会有远方的客人来拜访你，礼尚往来吗。 ');
INSERT INTO `msyuce` VALUES (42, '眼跳', '6', '左', '左眼跳有人请你吃饭，试试看。 ');
INSERT INTO `msyuce` VALUES (43, '眼跳', '7', '左', '左眼跳是有饮食之喜，你等着吧！ ');
INSERT INTO `msyuce` VALUES (44, '眼跳', '8', '左', '左眼跳诸事吉利、生意昌盛。 ');
INSERT INTO `msyuce` VALUES (45, '眼跳', '9', '左', '左眼跳今日会破财，看住你的钱包，如是囊中羞涩者也就不必太担忧了。 ');
INSERT INTO `msyuce` VALUES (46, '眼跳', '10', '左', '左眼跳有客来访，免不了要买点菜招待招待。 ');
INSERT INTO `msyuce` VALUES (47, '眼跳', '11', '左', '左眼跳有客大驾光临，喜事喜事！ ');
INSERT INTO `msyuce` VALUES (48, '眼跳', '12', '左', '左眼跳有贵客会来看望你，礼物是少不了的。 ');
INSERT INTO `msyuce` VALUES (49, '眼跳', '1', '右', '右眼跳是有人会邀请你吃饭，到时鲍鱼、鱼翅尽管点。千万别心软。 ');
INSERT INTO `msyuce` VALUES (50, '眼跳', '2', '右', '右眼跳有人在思念你，会不会是你的梦中情人？');
INSERT INTO `msyuce` VALUES (51, '眼跳', '3', '右', '右眼跳是吉人天下，万事顺畅。 ');
INSERT INTO `msyuce` VALUES (52, '眼跳', '4', '右', '右眼跳万事平安，不必担忧。 ');
INSERT INTO `msyuce` VALUES (53, '眼跳', '5', '右', '右眼跳会有损害，小心身边的事物。 ');
INSERT INTO `msyuce` VALUES (54, '眼跳', '6', '右', '右眼跳有凶恶，去拜拜菩萨求个平安。 ');
INSERT INTO `msyuce` VALUES (55, '眼跳', '7', '右', '右眼跳是有险恶，喧嚣和吵架之处避免去，明哲保身吗？ ');
INSERT INTO `msyuce` VALUES (56, '眼跳', '8', '右', '右眼跳有小损，就算救困扶危。');
INSERT INTO `msyuce` VALUES (57, '眼跳', '9', '右', '右眼跳有喜事，不妨试着买张福利彩票，百万大奖在等着你。 ');
INSERT INTO `msyuce` VALUES (58, '眼跳', '10', '右', '右眼跳有亲朋好友来光临，不亦乐乎吗。 ');
INSERT INTO `msyuce` VALUES (59, '眼跳', '11', '右', '右眼跳会有佳人邀你参加聚会，快点打扮整齐等着。 ');
INSERT INTO `msyuce` VALUES (60, '眼跳', '12', '右', '右眼跳有是非，能忍则忍，退一步海阔天空吗。 ');
INSERT INTO `msyuce` VALUES (61, '喷嚏', '1', '', '朋友邀请聚会会餐，相会便大吉。 ');
INSERT INTO `msyuce` VALUES (62, '喷嚏', '2', '', '有人在牵挂，让好事伴梦睡吧！ ');
INSERT INTO `msyuce` VALUES (63, '喷嚏', '3', '', '会有异性邀你共欢共饮，美事来了躲也躲不掉。 ');
INSERT INTO `msyuce` VALUES (64, '喷嚏', '4', '', '会得财得物，万事大吉。 ');
INSERT INTO `msyuce` VALUES (65, '喷嚏', '5', '', '今日万事平安快乐，饮食大吉。 ');
INSERT INTO `msyuce` VALUES (66, '喷嚏', '6', '', '有贵人相助，万事大吉。 ');
INSERT INTO `msyuce` VALUES (67, '喷嚏', '7', '', '有远客会光临，有喜事告知。 ');
INSERT INTO `msyuce` VALUES (68, '喷嚏', '8', '', '有饮食大吉之相，今日山珍海味是免不了了。哈哈！ ');
INSERT INTO `msyuce` VALUES (69, '喷嚏', '9', '', '可能工作太忙了，让你睡觉时恶梦惊恐，使得平时酒食不安，该休假出游玩玩了。 ');
INSERT INTO `msyuce` VALUES (70, '喷嚏', '10', '', '会有质疑问难之人来相求，别置之不理，共同发展求利吗！ ');
INSERT INTO `msyuce` VALUES (71, '喷嚏', '11', '', '有异性在思慕你，让我好得羡慕啊！ ');
INSERT INTO `msyuce` VALUES (72, '喷嚏', '12', '', '会有虚惊之事，如有朋相助便大吉顺畅。 ');
INSERT INTO `msyuce` VALUES (73, '心惊', '1', '', '有异性在思慕，您的艳福不浅呀！ ');
INSERT INTO `msyuce` VALUES (74, '心惊', '2', '', '会恶事面临，如能化险为夷必定会大吉大利。 ');
INSERT INTO `msyuce` VALUES (75, '心惊', '3', '', '有远客来访，并会邀集会餐，大吉大利。 ');
INSERT INTO `msyuce` VALUES (76, '心惊', '4', '', '有友人来邀请，饮食不愁。 ');
INSERT INTO `msyuce` VALUES (77, '心惊', '5', '', '有人邀请你去光临盛会，打扮打扮，让人赏心悦目一番。 ');
INSERT INTO `msyuce` VALUES (78, '心惊', '6', '', '有贵人相助，万事大吉。 ');
INSERT INTO `msyuce` VALUES (79, '心惊', '7', '', '有远客会光临，有喜事告知。 ');
INSERT INTO `msyuce` VALUES (80, '心惊', '8', '', '有异性在思念，会有喜事告知。 ');
INSERT INTO `msyuce` VALUES (81, '心惊', '9', '', '会有人邀请会餐，买单定不会是你，放心去吧！ ');
INSERT INTO `msyuce` VALUES (82, '心惊', '10', '', '有异性在惦记你哟，快致电于他/她，会有意想不到的喜事哦。 ');
INSERT INTO `msyuce` VALUES (83, '心惊', '11', '', '大喜降临，信者必会福星高招。 ');
INSERT INTO `msyuce` VALUES (84, '心惊', '12', '', '有奇恶要事发生，万事不要出门，能躲则躲。 ');
