-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:25
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `xzysnextday`
-- 

CREATE TABLE `xzysnextday` (
  `id` int(11) NOT NULL auto_increment,
  `xzmc` varchar(50) default NULL,
  `xzrq` varchar(50) default NULL,
  `yxqx` varchar(50) default NULL,
  `zhys` varchar(50) default NULL,
  `aqys` varchar(50) default NULL,
  `gzzk` varchar(50) default NULL,
  `nctz` varchar(50) default NULL,
  `jkzs` varchar(50) default NULL,
  `stzs` varchar(50) default NULL,
  `xyys` varchar(50) default NULL,
  `xysz` varchar(50) default NULL,
  `spxz` varchar(50) default NULL,
  `zhpg` longtext,
  `update_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- 导出表中的数据 `xzysnextday`
-- 

INSERT INTO `xzysnextday` VALUES (1, '牡羊座', '03/21 - 04/19', '2009-07-09', '4', '3', '4', '4', '<p>78%</p>', '<p>91%</p>', '<p>银色</p>', '<p>6</p>', '<p>狮子座</p>', '自我推销是最快让人接受你的方式。<br />\r今天的你在这方面的技巧掌握得很不错呢。既然如此在电话费上就不要太小气了，今天能掌握时间与机会最重要，尽量以行动电话取得最快速的联络。另外就是有些特价购物运，在不经意走进的店里意外发现特价品的预感，或是平常高价买不下手的东西今天在特价拍卖中却能以轻松的价格入手呢。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '2009-07-08 00:00:00');
INSERT INTO `xzysnextday` VALUES (2, '金牛座', '04/20 - 05/20', '2009-07-09', '4', '4', '2', '1', '<p>88%</p>', '<p>84%</p>', '<p>金色</p>', '<p>2</p>', '<p>金牛座</p>', '你的行为成为晚辈、新进人员参考的范本。<br />\r多花些心思指导他们，为往後需要他们协助时打好基础。而且还有意外後援出现的预感呢，只要感觉时间对了，就相信当时的感觉去做，连自己都感到意外般地顺利喔。长辈对你的建议也是大有帮助，多听听绝对有价值。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '2009-07-08 00:00:00');
INSERT INTO `xzysnextday` VALUES (3, '双子座', '05/21 - 06/21', '2009-07-09', '2', '3', '2', '3', '<p>77%</p>', '<p>50%</p>', '<p>深蓝色</p>', '<p>0</p>', '<p>水瓶座</p>', '自己的想法无法顺畅表达的感觉。<br />\r但责任并非全在别人，不应该责怪对方。先想想自己是不是在表现上太过主观了。任何联络事项请务必以记录方式留存下来，对今天在寻求依据时很重要喔。还有些摆阔好面子倾向，在别人眼光注目下做出摆排场的举动，因此散财的可能喔。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
INSERT INTO `xzysnextday` VALUES (4, '巨蟹座', '06/22 - 07/22', '2009-07-09', '3', '3', '3', '2', '<p>71%</p>', '<p>50%</p>', '<p>灰色</p>', '<p>9</p>', '<p>双鱼座</p>', '辨识别人的眼光似乎欠准确，容易为外表看似诚恳的人所欺骗。<br />\r除了会做表面功夫的人之外，穿著华丽的人更会让你误判。尤其一向注重外在奢华表象的天秤座人更要留意此点了，还可能因此导致自己金钱上损失的危险喔。还有对托关系走後门的人也应谨守分际，可能引出麻烦的暗示。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
INSERT INTO `xzysnextday` VALUES (5, '狮子座', '07/23 - 08/22', '2009-07-09', '3', '3', '2', '3', '<p>73%</p>', '<p>50%</p>', '<p>紫色</p>', '<p>8</p>', '<p>巨蟹座</p>', '明明是自己的疏忽却有将失败的责任转嫁到他人身上的图谋。<br />\r死不承认自己的错误只会更加惹人反感而已。最好在他人还没提出指责前就认错弥补，唯有如此才有挽回人心的机会。即使你认为对方是个好人应该没关系吧，不过过度自信就是人际关系的杀手喔。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
INSERT INTO `xzysnextday` VALUES (6, '处女座', '08/23 - 09/22', '2009-07-09', '3', '4', '3', '2', '<p>65%</p>', '<p>50%</p>', '<p>橘色</p>', '<p>1</p>', '<p>处女座</p>', '今天的你显得比平常脆弱敏感，自认为有自信的事一旦遭遇挫折也较难承受。<br />\r稍微一点小事却让你感到大受伤害的样子。看样子不大适合团体行动和待在人群里。中午的午餐早一点进食，晚上则最好是能多待在安静、可以一个人独处的地方。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
INSERT INTO `xzysnextday` VALUES (7, '天秤座', '09/23 - 10/23', '2009-07-09', '3', '3', '3', '2', '<p>84%</p>', '<p>51%</p>', '<p>棕色</p>', '<p>8</p>', '<p>射手座</p>', '容易被周围其他人的意见迷惑或左右自己的意识。<br />\r今天的你似乎三心二意、拿不定主意的情况比平常来得多喔。为了大家的进度著想，较为责任重大的事情最好拜托别人帮忙一下，或者是让给别人去负责吧。如果可以的话，重要的事情还是延到下周以後会比较好解决喔。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
INSERT INTO `xzysnextday` VALUES (8, '天蝎座', '10/24 - 11/22', '2009-07-09', '3', '3', '3', '3', '<p>43%</p>', '<p>56%</p>', '<p>绿色</p>', '<p>7</p>', '<p>天蝎座</p>', '效率较为低落的一天，往往浪费时间在某件事情上自己还不自知。<br />\r对时间分配上需多加规划才行了。另外今天得多在言词使用上多用心，不小心吐露出真心话却使得人际关系陷入紧张状态。在这种时候还是多忍耐些，即使是违心之论，还是宁愿多吹捧别人，别去碰对方的缺点或私下批评。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
INSERT INTO `xzysnextday` VALUES (9, '射手座', '11/23 - 12/21', '2009-07-09', '4', '4', '3', '3', '<p>83%</p>', '<p>87%</p>', '<p>白色</p>', '<p>2</p>', '<p>魔羯座</p>', '丢掉一些自尊与矜持，想要维持好人际关系，今天的你就需要表现得幽默风趣。<br />\r甚至夸张戏剧性一点，也就是多取悦别人啦。另外就是在营业上的表现也是顶不错的样子喔，面对客户时多放下身段维持低姿态，要争取业绩就要先抛开面子棉，而且对提升成绩还真的很有效呢。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
INSERT INTO `xzysnextday` VALUES (10, '魔羯座', '12/22 - 01/19', '2009-07-09', '3', '4', '3', '2', '<p>68%</p>', '<p>65%</p>', '<p>深红色</p>', '<p>5</p>', '<p>魔羯座</p>', '对周围流传的消息产生迷惑，也因一时的判断错误而有小错误的暗示。<br />\r而自己又三心二意的，拿不定主意。应避免自己一厢情愿的想法，多多寻求别人的意见。而今天父母亲是你最好的心事谘询者，晚饭後与他们坐下来聊聊，感觉心里安详稳定不少呢。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
INSERT INTO `xzysnextday` VALUES (11, '水瓶座', '01/20 - 02/18', '2009-07-09', '2', '3', '2', '3', '<p>51%</p>', '<p>53%</p>', '<p>草绿色</p>', '<p>3</p>', '<p>水瓶座</p>', '与周围的配合协调是今天最该注重的。<br />\r自己的想法、主张尽可能摆到第二位，今天一切以团体的和谐为最重要。只是也因为受到他人委托事情或手边杂务较多的影响，有些工作一下堆积而来的感觉，处理事务时难免就稍微有著混乱感。不妨适时地来一杯咖啡，回复运气与安定心神的妙方。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
INSERT INTO `xzysnextday` VALUES (12, '双鱼座', '02/19 - 03/20', '2009-07-09', '4', '4', '4', '3', '<p>85%</p>', '<p>79%</p>', '<p>橘色</p>', '<p>9</p>', '<p>处女座</p>', '与多人数的团体一起活动的时间里感觉最为幸运呢。<br />\r不论是参与商场、校际活动或是下班下课後的休闲活动都以多人数最佳。人数越多游乐运与沟通运也越旺盛，只要有人邀约就呼朋引伴一起参加吧。还有像是包水饺等大家一起动手做的料理最适合今天的融洽气氛呢。</div><div class="clear"></div></div><!-- 星座运势内容end --><div class="clear"></div>\r</div>\r<div class="clear"></div>\r', '0000-00-00 00:00:00');
