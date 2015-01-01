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
-- 表的结构 `qtbj`
-- 

CREATE TABLE `qtbj` (
  `id` int(11) NOT NULL auto_increment,
  `tg` varchar(50) default NULL,
  `dz` varchar(50) default NULL,
  `content` longtext,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=241 ;

-- 
-- 导出表中的数据 `qtbj`
-- 

INSERT INTO `qtbj` VALUES (121, '甲', '子', '木性生寒,丁先庚后,丙火为佐,必须支见巳寅,方为贵格。');
INSERT INTO `qtbj` VALUES (122, '乙', '子', '寒木向阳,专用丙火,忌见癸水。');
INSERT INTO `qtbj` VALUES (123, '丙', '子', '气近二阳,丙火弱中复强,故用壬水,取戊制之,无戊用己。');
INSERT INTO `qtbj` VALUES (124, '丁', '子', '庚金劈甲引丁,甲木为尊,庚金为佐。戊癸权宜取用。');
INSERT INTO `qtbj` VALUES (125, '戊', '子', '丙火为尚,甲木为佐。');
INSERT INTO `qtbj` VALUES (126, '己', '子', '三冬己土,非丙暖不生。壬水太旺,取戊土制之,土多,取甲木疏之。');
INSERT INTO `qtbj` VALUES (127, '庚', '子', '仍取丁甲,次取丙火照暖,丙丁须临寅巳午未戌支,方为有力。一派金水,不入和暖之乡,孤贫。');
INSERT INTO `qtbj` VALUES (128, '辛', '子', '冬月辛金,不能缺丙火温暖,余皆酌用。');
INSERT INTO `qtbj` VALUES (129, '壬', '子', '水旺宜戊,调候宜丙,丙戊必须兼用。');
INSERT INTO `qtbj` VALUES (130, '癸', '子', '丙火解冻,辛金滋扶。');
INSERT INTO `qtbj` VALUES (131, '甲', '丑', '丁火必不可少,通根巳寅,甲木为助,用庚劈甲引丁。');
INSERT INTO `qtbj` VALUES (132, '乙', '丑', '寒谷回春,专用丙火。');
INSERT INTO `qtbj` VALUES (133, '丙', '丑', '喜壬为用,土多不可少甲。');
INSERT INTO `qtbj` VALUES (134, '丁', '丑', '庚金劈甲引丁,甲木为尊,庚金为佐。戊癸权宜取用。');
INSERT INTO `qtbj` VALUES (135, '戊', '丑', '丙火为尚,甲木为佐。');
INSERT INTO `qtbj` VALUES (136, '己', '丑', '三冬己土,非丙暖不生。壬水太旺,取戊土制之,土多,取甲木疏之。');
INSERT INTO `qtbj` VALUES (137, '庚', '丑', '仍取丁甲,次取丙火照暖,丙丁须临寅巳午未戌支,方为有力。一派金水,不入和暖之乡,孤贫。');
INSERT INTO `qtbj` VALUES (138, '辛', '丑', '冬月辛金,不能缺丙火温暖,丙先壬后,戊己次之,总之丙火不可少也。');
INSERT INTO `qtbj` VALUES (139, '壬', '丑', '上半月专用丙火,下半月用丙,甲木为佐。');
INSERT INTO `qtbj` VALUES (140, '癸', '丑', '丙火解冻,通根寅巳午未戌方妙。支成金局,要丙透得地。支成火局,又宜用庚辛。');
INSERT INTO `qtbj` VALUES (141, '甲', '寅', '调合气候为要,丙火为主,癸水为佐。');
INSERT INTO `qtbj` VALUES (142, '乙', '寅', '取丙火解寒,略取癸水为滋润,不宜困丙。');
INSERT INTO `qtbj` VALUES (143, '丙', '寅', '壬水为用,庚金发水之源为佐。');
INSERT INTO `qtbj` VALUES (144, '丁', '寅', '用庚金劈甲引丁。');
INSERT INTO `qtbj` VALUES (145, '戊', '寅', '无丙照暖,戊土不生,无甲疏劈,戊土不灵,无癸兹润,戊土不长。先丙、次甲、次癸。');
INSERT INTO `qtbj` VALUES (146, '己', '寅', '取丙解寒,忌见壬水,如水多,须以土为佐。土多用甲,甲多用庚。');
INSERT INTO `qtbj` VALUES (147, '庚', '寅', '用丙暖庚性,患土厚埋金,须甲疏泄。火多用土,支成火局用壬。');
INSERT INTO `qtbj` VALUES (148, '辛', '寅', '辛金失令,取己土为生身之本,欲得辛金发用,全赖壬水之功。壬己并用,以庚为助。');
INSERT INTO `qtbj` VALUES (149, '壬', '寅', '无比劫,不必用戊,专用庚金,丙火为佐。');
INSERT INTO `qtbj` VALUES (150, '癸', '寅', '用辛生癸水为源,无辛用庚。丙不可少。');
INSERT INTO `qtbj` VALUES (151, '甲', '卯', '阳刃驾杀,专用庚金,以戊己滋杀为佐。无庚,用丙丁泄秀,不取制杀。');
INSERT INTO `qtbj` VALUES (152, '乙', '卯', '以癸滋木,用丙泄秀,不宜见金。');
INSERT INTO `qtbj` VALUES (153, '丙', '卯', '专用壬水,水多用戊制之,身弱用印化之。');
INSERT INTO `qtbj` VALUES (154, '丁', '卯', '以庚去乙,以甲引丁。');
INSERT INTO `qtbj` VALUES (155, '戊', '卯', '无丙照暖,戊土不生,无甲疏劈,戊土不灵,无癸兹润,戊土不长。先丙、次甲、次癸。');
INSERT INTO `qtbj` VALUES (156, '己', '卯', '用甲忌与己土合化,次用癸水润之。');
INSERT INTO `qtbj` VALUES (157, '庚', '卯', '庚金暗强,专用丁火,借甲引丁,用庚劈甲。无丁用丙。');
INSERT INTO `qtbj` VALUES (158, '辛', '卯', '壬水为尊,见戊己为病,须甲制伏。');
INSERT INTO `qtbj` VALUES (159, '壬', '卯', '三春壬水绝地,取庚辛发水之源,水多用戊。');
INSERT INTO `qtbj` VALUES (160, '癸', '卯', '乙木司令,专用庚金,辛金为次。');
INSERT INTO `qtbj` VALUES (161, '甲', '辰', '用金必须丁火制之,为伤官制杀。无庚用壬。');
INSERT INTO `qtbj` VALUES (162, '乙', '辰', '若支成水局,取戊为佐。');
INSERT INTO `qtbj` VALUES (163, '丙', '辰', '专用壬水,土重以甲为佐。');
INSERT INTO `qtbj` VALUES (164, '丁', '辰', '以甲木引丁制土,次看庚金。木盛用庚,水盛用戊。');
INSERT INTO `qtbj` VALUES (165, '戊', '辰', '戊土司令,先用甲疏,次丙、次癸。');
INSERT INTO `qtbj` VALUES (166, '己', '辰', '先丙后癸,土暖而润,随用甲疏。');
INSERT INTO `qtbj` VALUES (167, '庚', '辰', '顽金宜丁,旺土用甲,不用庚劈。支火宜癸,干火宜壬。');
INSERT INTO `qtbj` VALUES (168, '辛', '辰', '若见丙火合辛,须有癸制丙。支见亥子申,为贵。');
INSERT INTO `qtbj` VALUES (169, '壬', '辰', '甲疏季土,次取庚金以发水源,金多须丙制之为妙。');
INSERT INTO `qtbj` VALUES (170, '癸', '辰', '上半月专用丙火,下半月虽用丙火,辛甲为佐。');
INSERT INTO `qtbj` VALUES (171, '甲', '巳', '调合气候,癸水为主。原局气润,庚丁为用。');
INSERT INTO `qtbj` VALUES (172, '乙', '巳', '月令丙火得禄,专用癸水,调候为急。');
INSERT INTO `qtbj` VALUES (173, '丙', '巳', '以庚为佐,忌戊制壬。');
INSERT INTO `qtbj` VALUES (174, '丁', '巳', '取甲引丁,甲多又取庚为先。');
INSERT INTO `qtbj` VALUES (175, '戊', '巳', '戊土建禄,先用甲疏劈,次取丙癸。');
INSERT INTO `qtbj` VALUES (176, '己', '巳', '调候不能无癸,土润不能无丙。');
INSERT INTO `qtbj` VALUES (177, '庚', '巳', '丙不熔金,惟喜壬制。次取戊土,丙火为佐。支成金局,变弱为强,须用丁火。');
INSERT INTO `qtbj` VALUES (178, '辛', '巳', '壬水淘洗,兼有调候之用,更有甲木制戊,一清彻底。');
INSERT INTO `qtbj` VALUES (179, '壬', '巳', '壬水弱极,取庚辛为源,壬癸比助。');
INSERT INTO `qtbj` VALUES (180, '癸', '巳', '无辛用庚。忌丁破格,有壬可免。');
INSERT INTO `qtbj` VALUES (181, '甲', '午', '木性虚焦,癸为主要。无癸用丁,亦宜运行北地。');
INSERT INTO `qtbj` VALUES (182, '乙', '午', '上半月专用癸水,下半月丙癸并用。');
INSERT INTO `qtbj` VALUES (183, '丙', '午', '壬庚以通根申宫为妙。');
INSERT INTO `qtbj` VALUES (184, '丁', '午', '火多以庚壬两透为贵。无壬用癸,为独杀当权。');
INSERT INTO `qtbj` VALUES (185, '戊', '午', '调候为急,先用壬水,次取甲木,丙火酌用。');
INSERT INTO `qtbj` VALUES (186, '己', '午', '调候不能无癸,土润不能无丙。');
INSERT INTO `qtbj` VALUES (187, '庚', '午', '专用壬水,癸次之,须支见庚辛为助。无壬癸,用戊己泄火之气。');
INSERT INTO `qtbj` VALUES (188, '辛', '午', '己无壬不湿,辛无己不生,故壬己并用,无壬用癸。');
INSERT INTO `qtbj` VALUES (189, '壬', '午', '取庚为源,取癸为佐,无庚用辛。');
INSERT INTO `qtbj` VALUES (190, '癸', '午', '庚辛为生身之本,但丁火司权,金难敌火,宜兼有比劫,方得庚辛之用。');
INSERT INTO `qtbj` VALUES (191, '甲', '未', '上半月同午月用癸,下半月用庚丁。');
INSERT INTO `qtbj` VALUES (192, '乙', '未', '润土滋木,喜用癸水,柱多金水,先用丙火。夏月壬癸,切忌戊己杂乱。');
INSERT INTO `qtbj` VALUES (193, '丙', '未', '以庚为佐。');
INSERT INTO `qtbj` VALUES (194, '丁', '未', '以甲木化壬引丁为用,用甲不能无庚,取庚为佐。');
INSERT INTO `qtbj` VALUES (195, '戊', '未', '调候为急,癸不可缺,次用丙火,土重不能无甲。');
INSERT INTO `qtbj` VALUES (196, '己', '未', '调候不能无癸,土润不能无丙。');
INSERT INTO `qtbj` VALUES (197, '庚', '未', '若支成土局,甲先丁后。');
INSERT INTO `qtbj` VALUES (198, '辛', '未', '先用壬水,取庚为佐,忌戊出,得甲制之,方吉。');
INSERT INTO `qtbj` VALUES (199, '壬', '未', '以辛金发水源,甲木疏土。');
INSERT INTO `qtbj` VALUES (200, '癸', '未', '上半月金神衰弱,火气炎热,宜比劫帮身,同五月。下半月无比劫亦可。');
INSERT INTO `qtbj` VALUES (201, '甲', '申', '先用庚,再取丁,为伤官制杀,无丁用壬,富而不贵。');
INSERT INTO `qtbj` VALUES (202, '乙', '申', '月垣庚金司令,取丙火制之,或癸水化之。不论用丙用癸,皆己土为佐。');
INSERT INTO `qtbj` VALUES (203, '丙', '申', '壬水通根申宫,壬多必取戊制。');
INSERT INTO `qtbj` VALUES (204, '丁', '申', '庚取劈甲,无甲用乙。用丙暖金晒甲,无庚甲而用乙者,见丙为枯草引灯。水旺用戊。');
INSERT INTO `qtbj` VALUES (205, '戊', '申', '寒气渐增,先用丙火,后用癸水。水多,用甲泄之。');
INSERT INTO `qtbj` VALUES (206, '己', '申', '丙火温土,癸水润土。七月庚金司令,丙能制金,癸能泄金。');
INSERT INTO `qtbj` VALUES (207, '庚', '申', '专用丁火,以甲引丁。');
INSERT INTO `qtbj` VALUES (208, '辛', '申', '壬水为尊,甲戊酌用。不可用癸水。');
INSERT INTO `qtbj` VALUES (209, '壬', '申', '取丁火佐戊制庚,戊土通根辰戌,丁火通根午戌,方可为用。');
INSERT INTO `qtbj` VALUES (210, '癸', '申', '庚金得禄,必丁火制金为用,丁火以通根午戌未为妙。');
INSERT INTO `qtbj` VALUES (211, '甲', '酉', '用丁制杀,用丙调候,丁丙并用为佐。');
INSERT INTO `qtbj` VALUES (212, '乙', '酉', '上半月癸先丙后,下半月用丙先癸后,无癸用壬。');
INSERT INTO `qtbj` VALUES (213, '丙', '酉', '四柱多丙,一壬高透为奇。无壬为癸。');
INSERT INTO `qtbj` VALUES (214, '丁', '酉', '庚取劈甲,无甲用乙。用丙暖金晒甲,无庚甲而用乙者,见丙为枯草引灯。水旺用戊。');
INSERT INTO `qtbj` VALUES (215, '戊', '酉', '赖丙照暖,喜水滋润。');
INSERT INTO `qtbj` VALUES (216, '己', '酉', '取辛辅癸。');
INSERT INTO `qtbj` VALUES (217, '庚', '酉', '用丁火煅金,兼用丙火调候。');
INSERT INTO `qtbj` VALUES (218, '辛', '酉', '壬水淘洗,如见戊己,须甲制土。支成金局,无壬,须用丁火。');
INSERT INTO `qtbj` VALUES (219, '壬', '酉', '无甲,用金发水之源,名独水犯庚辛,体全之义。');
INSERT INTO `qtbj` VALUES (220, '癸', '酉', '辛金为用,丙火佐之,名水暖金温,须隔位同透为妙。');
INSERT INTO `qtbj` VALUES (221, '甲', '戌', '土旺者用甲木,木旺者用庚金,丁壬癸为佐。');
INSERT INTO `qtbj` VALUES (222, '乙', '戌', '以金发水之源。见甲,名藤萝系甲。');
INSERT INTO `qtbj` VALUES (223, '丙', '戌', '忌土晦光,先取甲疏土,次用壬水。');
INSERT INTO `qtbj` VALUES (224, '丁', '戌', '一派戊土无甲,为伤官尽。');
INSERT INTO `qtbj` VALUES (225, '戊', '戌', '戊土当权,先用甲木,次取丙火。见金,先用癸水,后取丙火。');
INSERT INTO `qtbj` VALUES (226, '己', '戌', '九月土盛,宜甲木疏之,次用丙癸。');
INSERT INTO `qtbj` VALUES (227, '庚', '戌', '土厚先用甲疏,次用壬洗。');
INSERT INTO `qtbj` VALUES (228, '辛', '戌', '九月辛金,火土为病,水木为用。');
INSERT INTO `qtbj` VALUES (229, '壬', '戌', '以甲制戌中戊土,丙火为佐。');
INSERT INTO `qtbj` VALUES (230, '癸', '戌', '专用辛金,忌戊土,要比劫兹甲制戊方妙。');
INSERT INTO `qtbj` VALUES (231, '甲', '亥', '用庚金,取丁火制之,丙火调候。水旺用戊。');
INSERT INTO `qtbj` VALUES (232, '乙', '亥', '乙木向阳,专用丙火,水多以戊为佐。');
INSERT INTO `qtbj` VALUES (233, '丙', '亥', '月垣壬水秉令,水旺用甲木化之。身杀两旺,用戊制之。火旺用壬,木旺宜庚。');
INSERT INTO `qtbj` VALUES (234, '丁', '亥', '庚金劈甲引丁,甲木为尊,庚金为佐。戊癸权宜取用。');
INSERT INTO `qtbj` VALUES (235, '戊', '亥', '非甲不灵,非丙不暖。');
INSERT INTO `qtbj` VALUES (236, '己', '亥', '三冬己土,非丙暖不生。初冬壬旺,取戊土制之,土多,取甲木疏之。');
INSERT INTO `qtbj` VALUES (237, '庚', '亥', '水冷金寒爱丙丁,甲木辅丁。');
INSERT INTO `qtbj` VALUES (238, '辛', '亥', '先壬后丙,名金白水清,余皆酌用。');
INSERT INTO `qtbj` VALUES (239, '壬', '亥', '若甲出制戊,须以庚金为救。');
INSERT INTO `qtbj` VALUES (240, '癸', '亥', '亥中甲木长生,泄散元神,宜用庚辛。水多用戊,金多用丁。');
