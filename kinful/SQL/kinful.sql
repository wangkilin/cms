-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2010 年 09 月 12 日 14:38
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `kinful`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `item`
-- 

CREATE TABLE `item` (
  `id` mediumint(12) NOT NULL auto_increment,
  `parent_id` mediumint(12) NOT NULL default '0',
  `list_id` mediumint(12) NOT NULL default '0',
  `title` varchar(80) NOT NULL default '',
  `cotent` text NOT NULL,
  `is_show` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- 
-- 导出表中的数据 `item`
-- 

INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (1, 0, 0, '关于我们', '<p>\r\n\r\n  北瓜数码工作室致力于网站开发与网络组建,主要为企业客户提供网站建设，网页设计制作，数据库程序开发，技术支持，平面及动画设计以及办公局域网的组建等网络与计算机相关服务。我们拥有专业从事此领域的开发设计师及技术开发人员，并在实践中积累了丰富的经验。\r\n  随着互联网的普及与发展，网站已逐渐成为形象宣传、产品展示推广、信息沟通的最方便快捷的桥梁。凭借高水平的设计开发实力，我们确保开发的每一个网站的最终品质，以使我们服务的企业拥有一流的个性化的企业或电子商务网站。我们本着客户至上的经营理念，为您提供优质、高效、快捷的服务。我们重视客户感受，不断提升服务水平，并与客户建立成熟、稳定的服务保障体系。同时客户的选择和好评，是我们团队不断追求的目标。   \r\n  我们是精益求精的团队，是开拓进取的团队，是拼搏向上的团队！我们将以崭新的理念，超凡的创意，卓越的品质，努力把北瓜数码工作室打造成为互联网以及多媒体行业的知名品牌！\r\n</p>', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (2, 0, 0, '我们做什么', '<p>\r\n○网站建设 ○域名注册 ○虚拟主机 ○网页制作 \r\n○程序开发 ○动画之作 ○网站推广 ○网站维护 \r\n○局域网组建 \r\n  北瓜数码工作室有着丰富的网站建设经验和实力，涵盖了从域名申请----空间租用----网页制作-----数据库开发----网站建成后的维护等等的一整套建站体系，实现了网站建设的一体化服务特色。\r\n  作为我们的客户的您，将可免费登陆到北瓜数码网站的企业名录中。北瓜数码将使您公司的宣传起到更强劲的效果。\r\n  当前，国内有许多中小企业没有自己的网络维护专员或者还没有实现现有计算机的网络化。北瓜数码竭力为当前存在办公网络问题的中小企业解决组建办公局域网方面难题，使您的企业实现办公效率化，网络化！\r\n\r\n', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (3, 0, 0, '', '', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (4, 0, 0, '追求理念', '<p>\r\n\r\n团结敬业\r\n  开拓创新\r\n    求实进取\r\n  团结敬业：团结为力量聚焦，只有团结才会有强大的力量；敬业为立业之本，不敬业者终究一事无成。工作室成员团结一心，对工作兢兢业业，服务真诚有礼。 \r\n\r\n  开拓创新：开拓为进步的先决条件，创新是活力的供给来源。没有开拓创新的精神则失去了工作室继续发展的潜力, 后果是不堪设想的，所以我们作为互联网行业的新兴力量，不断更新自己的产品，以适应市场的需要，力争走在市场的前面，早日打造工作室的优秀品牌。 \r\n\r\n  求实进取：求实进取是为成功的云梯，只有在求实中进取的人，才会不断登上新的巅峰。我们在求实中谈进取，同时，我们也以积极进取的态度面对人生。\r\n', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (5, 0, 0, '网站建设', '<p>\r\n\r\n  随着互联网的普及与发展，网站已逐渐成为形象宣传、产品展示推广、信息沟通的最方便快捷的桥梁。企业通过建立自己的网站，可以充分地利用互联网，收集和发布商业信息，利用网上丰富的信息资源开展对外交流，进行各种电子商务、网络营销等商业行为，在互联网上为企业树立全新的企业形象，通过互联网在企业与社会各界及消费者之间建立高效的沟通渠道，在国际化进程加快及我国加入WTO所带来的竞争环境，提高企业经济效率和竞争力．\r\n  凭借超强的设计开发实力，我们确保开发的每一个网站的最终品质，以使我们服务的企业拥有一流的个性化网站。使网站成为企业的宣传平台以提升企业形象与品牌价值。\r\n', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (6, 0, 0, '网页制作', '<P>\r\n  像报纸电视一样，网络是一个媒体，同样需要设计包装才会起到商业效果。网页制作的好坏决定了顾客对网站的感受和印象，在非常大的程度上影响顾客是否会再次访问。\r\n\r\n　　但现在很多站点，尤其国内部分企业在注册了自己的国际域名和租赁了庞大的站点空间后，却忽视了主页的精细制作，以致很多站点效果平平，并未达到网络预计效果。这是非常遗憾的！\r\n\r\n　　我们一直在追求技术与美感相融合的创意设计，创造企业良好的网路形象，加强宣传力度。以专业的设计与技术为客户创意与众不同的出色主页，达到客户商业建站的目的。 \r\n\r\n　　首页设计价格： 500元/页 \r\n\r\n　　首页也可以说是企业的网上的“门面”，是浏览者最先看到的页面，一般需要用创意将企业的徽标、文化色彩体现出来，所以，对设计要求尤为重要。 \r\n\r\n　　Flash首页设计价格： 800元/页 \r\n\r\n　　目前已经在国内开始流行的一种新技术实现的网络多媒体效果，比较适合企业形象的创意发挥。制作技术相对来说比较复杂。 \r\n\r\n　　结构页设计价格： 300元/页 \r\n\r\n　　结构页是浏览者停留最多时间的页面，通常好的结构页可以让用户非常方便的查询到所需要的信息。 \r\n\r\n　　静态内页设计价格： 150元/页 \r\n\r\n　　内页是网站的内容部分，不仅仅是文字排版，还需要对网页文件的大小和内容严格处理，注意和整个站点的风格相协调，这样，即便内容和图片比较多，同样也可以以较流畅的速度浏览。 \r\n\r\n　　动态内页设计价格： 300元/页 \r\n\r\n　　所谓动态不是指页面上的动画效果，是网页编制人员通过一些技术手段，达到浏览者和站点具有互动交流信息的功能，像常见的论坛、社区、在线反馈等。\r\n\r\n', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (7, 0, 0, '系统开发', '<P>\r\n\r\n  网站系统开发可以为网站增添交互式功能，使一般的网站由单向传递信息转变成网站/用户双向交流，是实现网上交易，留住网站用户的关键。因此，网站系统开发是网站发挥互联网作用的必然要求。北瓜数码会根据客户的要求和网站内容的特点，结合网站页面设计的风格和选用的表现技术，建议合适的网站程序，以达到低投入，高效率的目的，真正体现电子商务的节省和高效。 \r\n　　北瓜数码在长期的网站开发中，通过与客户的长期沟通和配合，积累了大量的网站制作经验。同时也形成了一套有着浓郁特色的网站制作套件和其他网络软件。\r\n', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (8, 0, 0, '局域网组建', '  北瓜数码真情服务――局域网组建。\r\n  服务于小型办公网络。解决中小企业网络办公自动化问题。', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (9, 0, 0, '动画制作', '  北瓜数码工作室鼎力推出的服务项目――动画制作。\r\n\r\n  如果你的公司（个人）需要动画媒体来实现，还不赶快联系我们！！\r\n\r\n  北瓜数码工作室的动画制作师拥有多年的动画制作经验，曾经为多家企业制作网站首页动画。凭借超强的技术实力，建立了很好的客户关系！\r\n', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (10, 0, 0, '网站作品', '<table width="96%"  border="0" cellspacing="8" cellpadding="0">\r\n      <tr>\r\n        <td width="193"><a href="../images/works/1.gif"><img src="../images/works/1.gif" width="193" height="136" border="0"></a></td>\r\n        <td valign="top">\r\n          工作室主页――以绿色和蓝色为基色。\r\n          绿色象征发展，蓝色象征科技</td>\r\n      </tr>\r\n      <tr>\r\n        <td>&nbsp;</td>\r\n        <td valign="top">&nbsp;</td>\r\n      </tr>\r\n      <tr>\r\n        <td>&nbsp;</td>\r\n        <td valign="top">&nbsp;</td>\r\n      </tr>\r\n      <tr>\r\n        <td><a href="../images/works/2.gif"><img src="../images/works/2.gif" width="191" height="146" border="0"></a></td>\r\n        <td valign="top">安庭信图文――整个页面体现了公司图文方面的设计能力。优秀的色彩搭配。</td>\r\n      </tr>\r\n    </table>', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (11, 0, 0, 'Flash动画', '<table width="96%"  border="0" cellspacing="8" cellpadding="0">\r\n      <tr>\r\n        <td width="193">&nbsp;</td>\r\n        <td>&nbsp;</td>\r\n      </tr>\r\n      <tr>\r\n        <td>&nbsp;</td>\r\n        <td>&nbsp;</td>\r\n      </tr>\r\n      <tr>\r\n        <td><a href="../images/works/flash/1.swf"><img src="../images/works/flash/1.gif" width="189" height="104" border="0"></a></td>\r\n        <td valign="top">安庭信图文――整个页面体现了公司图文方面的设计<br>\r\n          <br>          \r\n          能力。优秀的色彩搭配。</td>\r\n      </tr>\r\n    </table>', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (12, 0, 0, '建网常识', '\r\n如何用ASP连接SQLSERVER数据库？ \r\n\r\n答：请参照相关程序 Set conn = Server.CreateObject("ADODB.Connection") conn.Open "driver={SQL Server};server=主机ip地址; uid=用户名;pwd=密码;database=数据库名" conn open \r\n\r\n如何连接access数据库？ \r\n\r\n答：请参照相关程序： Set Conn=Server.CreateObject("ADODB.Connection") Connstr="DBQ="+server.mappath("aaa/bbspp1.mdb")+";DefaultDir=; DRIVER={Microsoft Access Driver (*.mdb)};DriverId=25;FIL=MS Access; ImplicitCommitSync=Yes;MaxBufferSize=512;MaxScanRows=8;PageTimeout=5; SafeTransactions=0;Threads=3;UserCommitSync=Yes;" Conn.Open connstr注意使用相对路径server.mappath("aaa/bbspp1.mdb")\r\n\r\n', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (13, 0, 0, '常见问题', '为何上传内容后无法显示? \r\n\r\n答：a.检查您的网站首页index.htm文件有没有上传到www目录下，或文件名是否有大写字母或全是大写字母。 \r\n\r\n　　b.可能是编程语句有问题,路径不对。 \r\n\r\n　　c.可能是表面上传上去了，但由于ftp中间断开，上传后文件字节数0字节或负数字节，请重新上传。 \r\n\r\n　　d.文件名不能用汉字或大写英文字母。', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (14, 0, 0, '邮件支持', '\r\n\r\n  邮件支持：itnoon@126.com', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (15, 0, 0, 'QQ支持', 'QQ支持\r\n', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (16, 0, 0, '联系方式', 'Email:<a href="mailto:itnoon@126.com">itnoon@126.com</a>\r\n\r\nMSN:wangkilin@hotmail.com\r\n\r\n', 1);
INSERT INTO `item` (`id`, `parent_id`, `list_id`, `title`, `cotent`, `is_show`) VALUES (17, 0, 0, '反馈留言', '', 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_block`
-- 

CREATE TABLE `my_block` (
  `block_id` tinyint(4) NOT NULL auto_increment COMMENT '区块ID',
  `block_name` varchar(250) NOT NULL COMMENT '区块名称',
  `module_id` tinyint(3) NOT NULL COMMENT '所属模块ID',
  `params` tinytext COMMENT '传递给模块的参数',
  `type` tinyint(1) NOT NULL default '0' COMMENT '显示的形式。 0：菜单， 1：块',
  `support_type` tinyint(2) NOT NULL default '15' COMMENT '模块支持访问类型： 1－web，2－wap， 4－rss。 可以同时支持多个类型。 按照或运算。',
  `is_admin` tinyint(1) NOT NULL default '0' COMMENT '是否为后台管理块',
  `block_note` varchar(255) default NULL COMMENT '块内容注释信息',
  PRIMARY KEY  (`block_id`),
  KEY `module_id` (`module_id`),
  KEY `module_id_2` (`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- 
-- 导出表中的数据 `my_block`
-- 

INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (1, 'login', 1, 'modName=login\r\ndirection=h', 1, 7, 0, 'Login description');
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (2, 'system_login', 1, 'type=login', 1, 7, 0, 'Login description');
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (3, 'logo', 1, 'type=media\r\nmedia_type=logo', 1, 7, 0, 'Media Logo description');
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (4, 'banner', 1, 'type=media\r\nmedia_type=banner', 1, 1, 0, 'Media banner description');
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (5, 'bg_music', 1, 'type=media\r\nmedia_type=flash_mp3', 1, 1, 0, 'backgroud music, played by flash, and file format is MP3');
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (6, 'menu', 1, 'type=menu\r\nmenu_list_id=3', 1, 1, 0, NULL);
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (7, 'admin_menu', 1, 'type=menu\r\nmenu_list_id=3', 0, 1, 1, 'Menu description');
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (8, 'randomNews', 2, 'newsType=random\r\ntype=news', 1, 15, 0, '随机抽取新闻');
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (9, 'sameCategoryNews', 2, 'type=news', 1, 15, 0, '根据所查看的新闻， 列出同类新闻');
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (10, 'getLatestNews', 2, 'type=news\r\nnewsType=latest', 1, 15, 0, '获取最新的新闻');
INSERT INTO `my_block` (`block_id`, `block_name`, `module_id`, `params`, `type`, `support_type`, `is_admin`, `block_note`) VALUES (11, 'front_head_menu', 1, 'type=menu\r\nmenu_list_id=2', 1, 15, 0, '前台顶部菜单列表');

-- --------------------------------------------------------

-- 
-- 表的结构 `my_category`
-- 

CREATE TABLE `my_category` (
  `category_id` int(10) NOT NULL auto_increment,
  `parent_id` int(10) NOT NULL default '0',
  `module_id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '分类标题',
  `description` text COMMENT '描述',
  `item_count` int(10) NOT NULL default '0' COMMENT '下面有多少条内容',
  `ordering` int(10) NOT NULL default '0' COMMENT '排列顺序',
  `publish` tinyint(1) NOT NULL default '1' COMMENT '是否发布',
  `access_level` int(4) NOT NULL default '0' COMMENT '访问级别',
  `block_name` varchar(40) default NULL COMMENT '非空，表示加入块表。对应于block表里的name',
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='内容分类表' AUTO_INCREMENT=5 ;

-- 
-- 导出表中的数据 `my_category`
-- 

INSERT INTO `my_category` (`category_id`, `parent_id`, `module_id`, `title`, `description`, `item_count`, `ordering`, `publish`, `access_level`, `block_name`) VALUES (2, 0, 0, '公司动态', NULL, 1, 0, 1, 0, NULL);
INSERT INTO `my_category` (`category_id`, `parent_id`, `module_id`, `title`, `description`, `item_count`, `ordering`, `publish`, `access_level`, `block_name`) VALUES (3, 0, 0, '童装展示', NULL, 12, 0, 1, 0, NULL);
INSERT INTO `my_category` (`category_id`, `parent_id`, `module_id`, `title`, `description`, `item_count`, `ordering`, `publish`, `access_level`, `block_name`) VALUES (4, 0, 0, '公司介绍', NULL, 2, 0, 1, 0, NULL);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_channel`
-- 

CREATE TABLE `my_channel` (
  `channel_id` tinyint(4) NOT NULL auto_increment COMMENT '菜单ID',
  `parent_id` tinyint(4) NOT NULL COMMENT '父ID',
  `channel_name` varchar(250) NOT NULL COMMENT '菜单名称',
  `order` tinyint(2) NOT NULL COMMENT '本区号排序ID',
  `channel_link` varchar(250) default NULL COMMENT '菜单连接地址',
  `publish` tinyint(1) NOT NULL COMMENT '是否显示',
  `show_level` tinyint(2) NOT NULL default '0' COMMENT '对此级别以上的用户才可显示',
  `is_admin` tinyint(1) NOT NULL default '0' COMMENT '是否是后台管理频道',
  `page_id` int(8) NOT NULL COMMENT '对应 #_page 表的 page_id',
  PRIMARY KEY  (`channel_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `my_channel`
-- 

INSERT INTO `my_channel` (`channel_id`, `parent_id`, `channel_name`, `order`, `channel_link`, `publish`, `show_level`, `is_admin`, `page_id`) VALUES (1, 0, 'home', 1, '/', 1, 0, 0, 0);
INSERT INTO `my_channel` (`channel_id`, `parent_id`, `channel_name`, `order`, `channel_link`, `publish`, `show_level`, `is_admin`, `page_id`) VALUES (2, 0, 'news', 2, NULL, 1, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_config`
-- 

CREATE TABLE `my_config` (
  `conf_id` int(4) NOT NULL auto_increment,
  `conf_name` varchar(30) NOT NULL COMMENT '配置变量名',
  `conf_value` varchar(255) NOT NULL COMMENT '值',
  `conf_desc` varchar(255) default NULL COMMENT '描述',
  `bak` varchar(20) default NULL,
  PRIMARY KEY  (`conf_id`),
  KEY `conf_name` (`conf_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='配置信息表' AUTO_INCREMENT=19 ;

-- 
-- 导出表中的数据 `my_config`
-- 

INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (1, 'allow_register', '1', '是否允许注册', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (2, 'is_count_ip', '1', '是否进行IP统计', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (3, 'count_admin_ip', '0', '是否将后台管理记入IP统计', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (4, 'record_admin_sql', 'y', '是否记录后台管理的SQL语句', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (5, 'session_cache_expire', '3600', 'SESSION保留时间', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (6, 'position_in_file', '0', '页面显示区块是否写入配置文件', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (7, 'block_in_file', '0', '区块显示内容是否写入配置文件', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (8, 'site_name', '欢迎来到金福网! Welcome to kinful.com! ', '网站名称', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (9, 'register_email_unique', '1', '是否检测注册邮件唯一', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (10, 'admin_activity_user', '1', '帐户是否需要管理员激活', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (11, 'default_language', 'cn', '网站默认语言', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (12, 'db_int_seperator', ',', '数据库整型数据分割符号', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (13, 'module_in_file', '0', '模块信息是否放置在文件中。 1－file，0－DB', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (14, 'default_theme', 'kinful', '系统默认的模板', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (15, 'component_in_file', '0', '组件信息是否写入文件', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (16, 'menu_in_file', '0', '菜单信息是否写入文件', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (17, 'admin_theme', '2', '后台管理模板', NULL);
INSERT INTO `my_config` (`conf_id`, `conf_name`, `conf_value`, `conf_desc`, `bak`) VALUES (18, 'database_type', 'mysql,pgsql,mssql,oracle', '数据库类型定义', NULL);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_count_ip`
-- 

CREATE TABLE `my_count_ip` (
  `day` int(8) NOT NULL COMMENT 'Ymd格式，8位',
  `week` int(2) NOT NULL COMMENT '第几周',
  `h_0` int(7) NOT NULL COMMENT '0点访问数',
  `h_1` int(7) NOT NULL COMMENT '1点访问数',
  `h_2` int(7) NOT NULL COMMENT '2点访问数',
  `h_3` int(7) NOT NULL COMMENT '3点访问数',
  `h_4` int(7) NOT NULL COMMENT '4点访问数',
  `h_5` int(7) NOT NULL COMMENT '5点访问数',
  `h_6` int(7) NOT NULL COMMENT '6点访问数',
  `h_7` int(7) NOT NULL COMMENT '7点访问数',
  `h_8` int(7) NOT NULL COMMENT '8点访问数',
  `h_9` int(7) NOT NULL COMMENT '9点访问数',
  `h_10` int(7) NOT NULL COMMENT '10点访问数',
  `h_11` int(7) NOT NULL COMMENT '11点访问数',
  `h_12` int(7) NOT NULL COMMENT '12点访问数',
  `h_13` int(7) NOT NULL COMMENT '13点访问数',
  `h_14` int(7) NOT NULL COMMENT '14点访问数',
  `h_15` int(7) NOT NULL COMMENT '15点访问数',
  `h_16` int(7) NOT NULL COMMENT '16点访问数',
  `h_17` int(7) NOT NULL COMMENT '15点访问数',
  `h_18` int(7) NOT NULL COMMENT '18点访问数',
  `h_19` int(7) NOT NULL COMMENT '19点访问数',
  `h_20` int(7) NOT NULL COMMENT '20点访问数',
  `h_21` int(7) NOT NULL COMMENT '21点访问数',
  `h_22` int(7) NOT NULL COMMENT '22点访问数',
  `h_23` int(7) NOT NULL COMMENT '23点访问数',
  KEY `day` (`day`),
  KEY `week` (`week`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `my_count_ip`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `my_group`
-- 

CREATE TABLE `my_group` (
  `group_id` tinyint(3) NOT NULL auto_increment COMMENT '组ID',
  `parent_gid` tinyint(3) NOT NULL COMMENT '父ID',
  `group_name` varchar(40) NOT NULL COMMENT '组名',
  `admin_ids` varchar(100) NOT NULL COMMENT '组管理员的ID',
  `group_desc` varchar(255) default NULL COMMENT '描述',
  `group_roles` text COMMENT '组具有的权限列表',
  `user_ids` text COMMENT '包含的用户的ID组合，以逗号分开',
  `creator_id` int(4) NOT NULL COMMENT '创建改组的user ID',
  PRIMARY KEY  (`group_id`),
  KEY `group_name` (`group_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='组信息表' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `my_group`
-- 

INSERT INTO `my_group` (`group_id`, `parent_gid`, `group_name`, `admin_ids`, `group_desc`, `group_roles`, `user_ids`, `creator_id`) VALUES (1, 0, 'guest', ',1,', 'guest 组', ',1,2,3,', ',2,', 1);
INSERT INTO `my_group` (`group_id`, `parent_gid`, `group_name`, `admin_ids`, `group_desc`, `group_roles`, `user_ids`, `creator_id`) VALUES (2, 0, 'visitor', '1', 'visitors', ',1,2,', ',2,', 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_hits`
-- 

CREATE TABLE `my_hits` (
  `module_id` int(6) unsigned NOT NULL COMMENT 'module id',
  `hit_type` tinyint(1) NOT NULL default '2' COMMENT '点击的是分类， 还是具体内容： 分类-1； 内容-2',
  `hit_id` int(10) unsigned NOT NULL COMMENT '模块中的内容id',
  `m_1` int(10) NOT NULL default '0' COMMENT '一月点击次数',
  `m_2` int(10) NOT NULL default '0',
  `m_3` int(10) NOT NULL default '0',
  `m_4` int(10) NOT NULL default '0',
  `m_5` int(10) NOT NULL default '0',
  `m_6` int(10) NOT NULL default '0',
  `m_7` int(10) NOT NULL default '0',
  `m_8` int(10) NOT NULL default '0',
  `m_9` int(10) NOT NULL default '0',
  `m_10` int(10) NOT NULL default '0',
  `m_11` int(10) NOT NULL default '0',
  `m_12` int(10) NOT NULL default '0',
  PRIMARY KEY  (`module_id`,`hit_type`,`hit_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容点击次数， 按周统计';

-- 
-- 导出表中的数据 `my_hits`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `my_language`
-- 

CREATE TABLE `my_language` (
  `lang_id` tinyint(2) NOT NULL auto_increment COMMENT 'language ID',
  `lang_name` varchar(4) NOT NULL COMMENT 'language name',
  `creatot_id` int(8) NOT NULL COMMENT '添加人员ID',
  `install_date` bigint(11) NOT NULL COMMENT '添加日期',
  `publish` tinyint(1) NOT NULL COMMENT '是否公开使用',
  `desc` varchar(200) default NULL COMMENT '备注',
  PRIMARY KEY  (`lang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统具有的语言选项' AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `my_language`
-- 

INSERT INTO `my_language` (`lang_id`, `lang_name`, `creatot_id`, `install_date`, `publish`, `desc`) VALUES (1, 'en', 1, 11177777777, 1, '英语');
INSERT INTO `my_language` (`lang_id`, `lang_name`, `creatot_id`, `install_date`, `publish`, `desc`) VALUES (2, 'cn', 1, 11177777777, 1, '中文');

-- --------------------------------------------------------

-- 
-- 表的结构 `my_menu`
-- 

CREATE TABLE `my_menu` (
  `menu_id` tinyint(5) NOT NULL auto_increment COMMENT '菜单ID',
  `menu_list_id` tinyint(2) NOT NULL COMMENT '菜单列表ID',
  `parent_id` tinyint(5) NOT NULL COMMENT '父ID',
  `menu_name` varchar(250) NOT NULL COMMENT '菜单名称',
  `menu_order` tinyint(2) NOT NULL COMMENT '本区号排序ID',
  `menu_link` varchar(250) default NULL COMMENT '菜单连接地址',
  `open_mode` tinyint(1) NOT NULL default '0' COMMENT '打开链接模式： 0-当前窗口， 1-无导航新窗口， 2-不带导航新窗口',
  `publish` tinyint(1) NOT NULL COMMENT '是否显示',
  `show_level` tinyint(2) NOT NULL default '0' COMMENT '对此级别以上的用户才可显示',
  `is_admin` tinyint(1) NOT NULL default '0' COMMENT '是否是后台管理菜单',
  `menu_class` varchar(64) NOT NULL COMMENT 'menu 使用的css class',
  `module_id` int(4) NOT NULL COMMENT 'menu 连接到的目的页是模块。',
  `params` text NOT NULL COMMENT '调用模块使用的参数',
  PRIMARY KEY  (`menu_id`),
  KEY `menu_list_id` (`menu_list_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

-- 
-- 导出表中的数据 `my_menu`
-- 

INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (1, 1, 0, 'IT新闻', 0, '', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (2, 1, 1, '内部新闻', 1, NULL, 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (3, 3, 0, '菜单管理', 2, '?yemodule=system&admin=menu', 0, 1, 0, 1, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (5, 1, 0, '公司新闻', 0, '', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (6, 1, 0, '行业新闻', 0, '', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (7, 1, 5, '最新动态', 0, '', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (8, 1, 6, '产业前沿', 0, NULL, 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (9, 3, 0, '页面管理', 1, '?yemodule=system&admin=page', 0, 1, 0, 1, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (10, 3, 3, '新建菜单组', 2, '?yemodule=system&admin=menu&form_action=new', 0, 1, 0, 1, 'menu_admin_menu_list_class admin_menu_add_new_item', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (11, 3, 0, '首页', 0, 'index.php', 0, 1, 0, 1, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (12, 3, 0, '内容管理', 5, '?yemodule=system&admin=module', 0, 1, 0, 1, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (13, 3, 0, '系统管理', 0, '?yemodule=system&admin=system', 0, 1, 0, 1, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (14, 3, 3, '左侧菜单', 3, '', 0, 1, 0, 1, 'menu_admin_menu_list_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (15, 3, 13, '网站配置', 15, NULL, 0, 1, 0, 1, 'menu_admin_site_config_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (16, 3, 3, '头部菜单', 4, NULL, 0, 1, 0, 1, 'menu_admin_menu_list_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (17, 3, 3, '右侧菜单', 5, '', 0, 1, 0, 1, 'menu_admin_menu_list_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (18, 3, 3, '底部菜单', 6, '', 0, 1, 0, 1, 'menu_admin_menu_list_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (20, 6, 0, '新闻动态', 0, '', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (21, 3, 0, '组件管理', 3, NULL, 0, 1, 0, 1, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (22, 3, 21, '媒体管理', 3, NULL, 0, 1, 0, 1, 'menu_admin_plugin_media_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (23, 3, 21, '内容评论', 3, NULL, 0, 1, 0, 1, 'menu_admin_plugin_comments_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (24, 3, 21, '投票系统', 3, NULL, 0, 1, 0, 1, 'menu_admin_plugin_vote_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (25, 3, 21, '表单系统', 3, NULL, 0, 1, 0, 1, 'menu_admin_plugin_form_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (26, 3, 13, '高级管理', 22, NULL, 0, 1, 0, 1, 'menu_admin_expert_management_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (27, 3, 26, '板块管理', 0, NULL, 0, 1, 0, 1, 'menu_admin_expert_block_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (28, 3, 9, '频道页面', 2, '?yemodule=system&admin=page&form_action=list&list=1', 0, 1, 0, 0, 'menu_admin_page_channel_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (29, 3, 9, '广告页面', 3, '?yemodule=system&admin=page&form_action=list&list=2', 0, 1, 0, 1, 'menu_admin_page_ad_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (30, 3, 9, '新建分类', 1, '?yemodule=system&admin=page&form_action=new', 0, 1, 0, 0, 'admin_menu_add_new_item menu_admin_page_management_add_new_class', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (31, 3, 12, '新闻管理', 0, '?yemodule=news', 0, 1, 0, 0, 'menu_admin_expert_block_class', 2, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (32, 3, 12, '产品管理', 0, '', 0, 1, 0, 0, 'menu_admin_expert_block_class', 2, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (33, 3, 3, '菜单列表', 1, '?yemodule=system&admin=menu', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (34, 3, 9, '页面分类', 0, '?yemodule=system&admin=page', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (35, 3, 13, '网站预览', 0, '../index.php', 1, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (36, 3, 9, '系统页面', 4, '?yemodule=system&admin=page&form_action=list&list=3', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (37, 3, 9, '首页管理', 0, '?yemodule=system&admin=page&form_action=update&page=0', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (38, 2, 0, '首 页', 0, 'index.php', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (39, 2, 0, '公司介绍', 0, '?yemodule=news&news_id=19', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (40, 2, 0, '童装产品', 0, '?yemodule=news&category_id=2', 0, 1, 0, 0, '', 0, '');
INSERT INTO `my_menu` (`menu_id`, `menu_list_id`, `parent_id`, `menu_name`, `menu_order`, `menu_link`, `open_mode`, `publish`, `show_level`, `is_admin`, `menu_class`, `module_id`, `params`) VALUES (41, 2, 0, '企业信息', 0, '?yemodule=news&category_id=4', 0, 1, 0, 0, '', 0, '');

-- --------------------------------------------------------

-- 
-- 表的结构 `my_menu_list`
-- 

CREATE TABLE `my_menu_list` (
  `menu_list_id` int(3) NOT NULL auto_increment COMMENT '菜单列表ID',
  `menu_list_name` varchar(80) NOT NULL COMMENT '菜单列表名字',
  `publish` tinyint(1) NOT NULL COMMENT '是否公开',
  PRIMARY KEY  (`menu_list_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- 导出表中的数据 `my_menu_list`
-- 

INSERT INTO `my_menu_list` (`menu_list_id`, `menu_list_name`, `publish`) VALUES (1, '左侧菜单', 1);
INSERT INTO `my_menu_list` (`menu_list_id`, `menu_list_name`, `publish`) VALUES (7, '主菜单', 1);
INSERT INTO `my_menu_list` (`menu_list_id`, `menu_list_name`, `publish`) VALUES (3, '后台管理菜单', 1);
INSERT INTO `my_menu_list` (`menu_list_id`, `menu_list_name`, `publish`) VALUES (6, '管理菜单', 1);
INSERT INTO `my_menu_list` (`menu_list_id`, `menu_list_name`, `publish`) VALUES (2, '头部菜单', 1);
INSERT INTO `my_menu_list` (`menu_list_id`, `menu_list_name`, `publish`) VALUES (4, '右侧菜单', 1);
INSERT INTO `my_menu_list` (`menu_list_id`, `menu_list_name`, `publish`) VALUES (5, '底部菜单', 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_module`
-- 

CREATE TABLE `my_module` (
  `module_id` tinyint(3) NOT NULL auto_increment COMMENT '模块ID',
  `module_name` varchar(80) NOT NULL COMMENT '标题',
  `support_end_page` tinyint(1) NOT NULL default '0' COMMENT '是否支持最终显示页面',
  `page_id` int(4) NOT NULL default '0' COMMENT '使用那个页面来展示内容',
  `menuable` tinyint(1) NOT NULL default '0' COMMENT '是否支持菜单',
  `channelable` tinyint(1) NOT NULL default '0' COMMENT '是否支持频道',
  `publish` tinyint(1) NOT NULL COMMENT '是否公开',
  `access_level` tinyint(2) NOT NULL default '0' COMMENT '进入模块的级别',
  `desc` varchar(200) default NULL COMMENT '模块的功能描述',
  PRIMARY KEY  (`module_id`),
  KEY `menuable` (`menuable`,`channelable`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- 导出表中的数据 `my_module`
-- 

INSERT INTO `my_module` (`module_id`, `module_name`, `support_end_page`, `page_id`, `menuable`, `channelable`, `publish`, `access_level`, `desc`) VALUES (1, 'system', 0, 0, 0, 0, 1, 0, NULL);
INSERT INTO `my_module` (`module_id`, `module_name`, `support_end_page`, `page_id`, `menuable`, `channelable`, `publish`, `access_level`, `desc`) VALUES (2, 'news', 0, 8, 0, 0, 1, 0, NULL);
INSERT INTO `my_module` (`module_id`, `module_name`, `support_end_page`, `page_id`, `menuable`, `channelable`, `publish`, `access_level`, `desc`) VALUES (3, 'logo', 0, 0, 0, 0, 1, 0, NULL);
INSERT INTO `my_module` (`module_id`, `module_name`, `support_end_page`, `page_id`, `menuable`, `channelable`, `publish`, `access_level`, `desc`) VALUES (4, 'banner', 0, 0, 0, 0, 1, 0, NULL);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_module_menu`
-- 

CREATE TABLE `my_module_menu` (
  `module_id` int(5) NOT NULL COMMENT 'module ID',
  `menu_name` varchar(80) NOT NULL COMMENT '菜单名称。 将被翻译',
  `params` text COMMENT '参数。 传递给 module_admin 函数',
  `desc` text COMMENT '描述信息',
  KEY `module_id` (`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模块中可以加入菜单列表的内容';

-- 
-- 导出表中的数据 `my_module_menu`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `my_news`
-- 

CREATE TABLE `my_news` (
  `news_id` int(10) NOT NULL auto_increment,
  `category_id` int(10) NOT NULL COMMENT '所属分类ID',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `publish` tinyint(1) NOT NULL default '1' COMMENT '是否发布',
  `title_color` varchar(6) default NULL COMMENT '标题颜色代码',
  `title_style` smallint(3) NOT NULL default '0' COMMENT '标题加粗， 斜体， 是否具有标题图片来表明新闻类型： 或运算',
  `title_media` varchar(400) default NULL COMMENT '标题图片路径',
  `intro_text` mediumtext COMMENT '简介内容',
  `full_text` text NOT NULL COMMENT '详细内容',
  `created_time` datetime NOT NULL COMMENT '建立时间',
  `created_by_id` int(10) NOT NULL COMMENT '内容建立者ID',
  `created_by_name` varchar(255) default NULL COMMENT '建立者名字',
  `modified_time` datetime NOT NULL COMMENT '修改时间',
  `modified_by_id` int(10) default NULL COMMENT '修改者ID',
  `modified_by_name` varchar(255) default NULL COMMENT '修改者名字',
  `start_time` datetime NOT NULL COMMENT '发布的起始时间',
  `end_time` datetime NOT NULL default '2030-12-31 23:59:59' COMMENT '发布的结束时间',
  `reference_url` varchar(255) default NULL COMMENT '参考网址',
  `weight` int(10) NOT NULL default '0' COMMENT '排序',
  `on_top` tinyint(1) NOT NULL default '0' COMMENT '是否置顶',
  `meta_key` varchar(255) default NULL COMMENT '页面关键字',
  `meta_desc` text COMMENT '页面关键字内容',
  `hits` int(10) NOT NULL default '0' COMMENT '点击次数',
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='详细内容表' AUTO_INCREMENT=21 ;

-- 
-- 导出表中的数据 `my_news`
-- 

INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (18, 3, '牛仔裤-6', 1, '  ', 0, NULL, '<p><img src="upload/images/true-religion-kids-jeans-2_small.jpg" alt="牛仔裤" width="69" height="92" /></p>', '<p><img src="upload/images/true-religion-kids-jeans-2.jpg" alt="牛仔裤" width="384" height="512" /></p>\r\n<p>产品名称：<span style="color: #993366;">牛仔裤 -6</span></p>\r\n<p>型号：<span style="color: #993366;">牛仔裤 -6</span></p>\r\n<p>详细介绍：详细介绍信息。。。。。。</p>', '2010-08-30 04:30:14', 1, 'wangkilin', '2010-08-30 04:31:23', 1, 'wangkilin', '2010-08-30 04:30:14', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (3, 2, 'title', 1, ' #ffff', 7, NULL, '<p>2010-12-11 11:11:11</p>', '<p>2010-12-11 11:11:11﻿</p>', '2010-08-17 09:44:55', 1, 'wangkilin', '0000-00-00 00:00:00', NULL, NULL, '2010-12-11 11:11:11', '2011-12-11 11:11:11', 'http://www.zhidianmijin.com', 10, 1, 'hello', 'hello kitty', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (6, 2, '关于金福建站系统', 1, ' ', 0, NULL, '<p>欢迎转载，转载请注明出处：Mambo中国 http://www.mambochina.net<br /><br />Mambo，中文意思为曼波音乐(源于古巴黑人音乐)，是这个星球上功能最强大的开 放源码的智能建站系统之一。在2004年4月20日伦敦举行的Linux用户和开发员大会上，Mambo从众多优秀的开放源码系统中脱颖而出，获得 2004年度最佳Linux开放源码系统奖项，和它同场竞技的有KDE、Firebird  SQL以及eGroupware等，这些都是知名度很高，被广泛使用的系统，现在却沦为Mambo的手下败将，可想而知，Mambo的魔力有多大！<br /><br />Mambo 是功能非常强大的智能建站系统，目前用户快超过了Phpnuke,他吸收了phpnuke,xoops的很多优点，更灵活，更强大，有数不清的插件和皮肤 下载！<br /><br />本文将给你一个较好的解释，Mambo是如何适合网站建设和管理的。</p>', '<p>欢迎转载，转载请注明出处：Mambo中国 http://www.mambochina.net<br /><br />Mambo，中文意思为曼波音乐(源于古巴黑人音乐)，是这个星球上功能最强大的开 放源码的智能建站系统之一。在2004年4月20日伦敦举行的Linux用户和开发员大会上，Mambo从众多优秀的开放源码系统中脱颖而出，获得 2004年度最佳Linux开放源码系统奖项，和它同场竞技的有KDE、Firebird  SQL以及eGroupware等，这些都是知名度很高，被广泛使用的系统，现在却沦为Mambo的手下败将，可想而知，Mambo的魔力有多大！<br /><br />Mambo 是功能非常强大的智能建站系统，目前用户快超过了Phpnuke,他吸收了phpnuke,xoops的很多优点，更灵活，更强大，有数不清的插件和皮肤 下载！<br /><br />本文将给你一个较好的解释，Mambo是如何适合网站建设和管理的。</p>', '2010-08-21 14:18:07', 1, 'wangkilin', '0000-00-00 00:00:00', NULL, NULL, '2010-08-21 14:18:07', '2030-12-31 23:59:59', 'http://www.zhidianmijin.com', 0, 1, 'keyword', '金福建站', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (7, 3, '时尚T-shirt', 1, '      ', 0, NULL, '<p><img src="upload/images/cloth_1.jpg" alt="T-shirt" /></p>', '<p><img src="upload/images/cloth_1.jpg" alt="T-shirt" /></p>\r\n<p><span style="color: #782d9f;">时尚T-shirt</span></p>', '2010-08-25 00:44:41', 1, 'wangkilin', '2010-08-30 03:54:16', 1, 'wangkilin', '2010-08-25 00:44:41', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (9, 3, '天真靓丽女童装', 1, '    ', 0, NULL, '<p><img src="upload/images/cloth_3.jpg" alt="天真靓丽女童装" /></p>', '<p><img src="upload/images/cloth_3.jpg" alt="天真靓丽女童装" /></p>\r\n<p><span style="color: #782d9f;">天真靓丽女童装</span></p>', '2010-08-25 05:32:29', 1, 'wangkilin', '2010-08-30 03:54:31', 1, 'wangkilin', '2010-08-25 05:32:29', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (8, 3, '精品小海军（7龄童）', 1, '    ', 0, NULL, '<p><img src="upload/images/cloth_2.jpg" alt="精品小海军" /></p>', '<p><img src="upload/images/cloth_2.jpg" alt="精品小海军" /></p>\r\n<p><span style="color: #782d9f;">精品小海军（7龄童）</span></p>', '2010-08-25 05:29:22', 1, 'wangkilin', '2010-08-30 03:53:07', 1, 'wangkilin', '2010-08-25 05:29:22', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (10, 3, '我型我秀运动款', 1, '     ', 0, NULL, '<p><img src="upload/images/cloth_4.jpg" alt="我型我秀运动款" /></p>', '<p><img src="upload/images/cloth_4.jpg" alt="我型我秀运动款" /></p>\r\n<p><span style="color: #782d9f;">我型我秀运动款</span></p>', '2010-08-26 00:21:03', 1, 'wangkilin', '2010-08-30 03:53:25', 1, 'wangkilin', '2010-08-26 00:21:03', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (11, 3, '品味小情侣', 1, '     ', 0, NULL, '<p><img src="upload/images/cloth_5.jpg" alt="品味小情侣" /></p>', '<p><img src="upload/images/cloth_5.jpg" alt="品味小情侣" /></p>\r\n<p><span style="color: #782d9f;">品味小情侣</span></p>', '2010-08-26 00:22:56', 1, 'wangkilin', '2010-08-30 03:53:43', 1, 'wangkilin', '2010-08-26 00:22:56', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (12, 3, '英姿飒爽大姐大', 1, '     ', 0, NULL, '<p><img src="upload/images/cloth_6.jpg" alt="英姿飒爽大姐大" /></p>', '<p><img src="upload/images/cloth_6.jpg" alt="英姿飒爽大姐大" /></p>\r\n<p><span style="color: #782d9f;">英姿飒爽大姐大</span></p>', '2010-08-26 00:24:43', 1, 'wangkilin', '2010-08-30 03:53:59', 1, 'wangkilin', '2010-08-26 00:24:43', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (14, 3, '牛仔裤-2', 1, '  ', 0, NULL, '<p><img src="upload/images/Kids-Jeans_small.jpg" alt="牛仔裤-2" width="70" height="93" /></p>', '<p><img src="upload/images/Kids-Jeans.jpg" alt="牛仔裤-2" width="338" height="450" /></p>\r\n<p>产品名称：<span style="color: #993366;">牛仔裤 -2</span></p>\r\n<p>型号：<span style="color: #993366;">牛仔裤 -2</span></p>', '2010-08-30 04:03:19', 1, 'wangkilin', '2010-08-30 04:14:24', 1, 'wangkilin', '2010-08-30 04:03:19', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (13, 3, '牛仔裤-1', 1, '   ', 0, NULL, '<p><img src="upload/images/726154_fpx_small.jpg" alt="牛仔裤" width="78" height="93" /></p>', '<p><img src="upload/images/726154_fpx.jpg" alt="牛仔裤" /></p>\r\n<p>产品名称：<span style="color: #993366;">牛仔裤 -1</span></p>\r\n<p>型号：<span style="color: #993366;">牛仔裤 -1</span></p>', '2010-08-30 02:44:44', 1, 'wangkilin', '2010-08-30 03:52:51', 1, 'wangkilin', '2010-08-30 02:44:44', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (15, 3, '牛仔裤-3', 1, ' ', 0, NULL, '<p><img src="upload/images/images_small.jpg" alt="牛仔裤" width="76" height="93" /></p>', '<p><img src="upload/images/images.jpg" alt="牛仔裤" width="133" height="164" /></p>\r\n<p>产品名称：<span style="color: #993366;">牛仔裤 -3</span></p>\r\n<p>型号：<span style="color: #993366;">牛仔裤 -3</span></p>\r\n<p>详细介绍：详细介绍信息。。。。。。</p>', '2010-08-30 04:09:08', 1, 'wangkilin', '0000-00-00 00:00:00', NULL, NULL, '2010-08-30 04:09:08', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (16, 3, '牛仔裤-4', 1, ' ', 0, NULL, '<p><img src="upload/images/kids_jeans_pants_small.jpg" alt="牛仔裤" width="83" height="93" /></p>', '<p><img src="upload/images/kids_jeans_pants.jpg" alt="牛仔裤" width="664" height="749" /></p>\r\n<p>产品名称：<span style="color: #993366;">牛仔裤 -4</span></p>\r\n<p>型号：<span style="color: #993366;">牛仔裤 -4</span></p>\r\n<p>详细介绍：详细介绍信息。。。。。。</p>', '2010-08-30 04:26:53', 1, 'wangkilin', '0000-00-00 00:00:00', NULL, NULL, '2010-08-30 04:26:53', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (17, 3, '牛仔裤-5', 1, ' ', 0, NULL, '<p><img src="upload/images/littlerivet2_small.jpg" alt="牛仔裤" width="92" height="62" /></p>', '<p><img src="upload/images/littlerivet2.jpg" alt="牛仔裤" width="600" height="400" /></p>\r\n<p>产品名称：<span style="color: #993366;">牛仔裤 -5</span></p>\r\n<p>型号：<span style="color: #993366;">牛仔裤 -5</span></p>\r\n<p>详细介绍：详细介绍信息。。。。。。</p>', '2010-08-30 04:28:30', 1, 'wangkilin', '0000-00-00 00:00:00', NULL, NULL, '2010-08-30 04:28:30', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (19, 4, '关于我们', 1, ' ', 0, NULL, '', '<p>这里是公司信息的介绍内容。 可以自由排版。</p>', '2010-09-02 13:26:27', 1, 'wangkilin', '0000-00-00 00:00:00', NULL, NULL, '2010-09-02 13:26:27', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);
INSERT INTO `my_news` (`news_id`, `category_id`, `title`, `publish`, `title_color`, `title_style`, `title_media`, `intro_text`, `full_text`, `created_time`, `created_by_id`, `created_by_name`, `modified_time`, `modified_by_id`, `modified_by_name`, `start_time`, `end_time`, `reference_url`, `weight`, `on_top`, `meta_key`, `meta_desc`, `hits`) VALUES (20, 4, '联系方式', 1, '      ', 0, NULL, '', '<p><span style="font-size: xx-small; color: #993366;">---------------------------------------------------------------------------------------------------</span></p>\r\n<p><strong><span style="color: #800080; font-size: medium;">新雨紫归缘制衣厂联系方式</span></strong></p>\r\n<p><span style="color: #993366;">办公电话：0419-2725022 </span></p>\r\n<p><span style="color: #993366;">手机：013555725022</span></p>', '2010-09-02 13:31:28', 1, 'wangkilin', '2010-09-02 14:10:42', 1, 'wangkilin', '2010-09-02 13:31:28', '2030-12-31 23:59:59', '', 0, 0, '', '', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_operation_record`
-- 

CREATE TABLE `my_operation_record` (
  `oper_time` bigint(10) NOT NULL COMMENT '操作时间',
  `user_id` int(8) NOT NULL COMMENT '用户ID',
  `module_id` tinyint(3) NOT NULL COMMENT '模块ID',
  `oper_sql` varchar(400) NOT NULL COMMENT 'SQL语句',
  KEY `oper_time` (`oper_time`),
  KEY `user_id` (`user_id`),
  KEY `module_id` (`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- 导出表中的数据 `my_operation_record`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `my_page`
-- 

CREATE TABLE `my_page` (
  `page_id` int(8) NOT NULL auto_increment COMMENT '自定义页面ID',
  `page_category_id` int(4) NOT NULL COMMENT '页面分类ID',
  `page_name` varchar(32) NOT NULL COMMENT '页面名称',
  `has_main_block` tinyint(1) NOT NULL COMMENT '是否具有主显示块',
  `publish` tinyint(1) NOT NULL COMMENT '是否显示',
  `show_level` tinyint(2) NOT NULL default '0' COMMENT '对此级别以上的用户才可显示',
  `template_id` int(8) default NULL COMMENT '模板ID',
  `support_type` tinyint(1) NOT NULL default '1' COMMENT '支持访问类型： 1－web，2－wap， 4－rss。 可以同时支持多个类型。 按照或运算。',
  `notes` varchar(256) NOT NULL COMMENT '当前记录备注信息',
  PRIMARY KEY  (`page_id`),
  KEY `page_category_id` (`page_category_id`),
  KEY `page_name` (`page_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='自定义的显示页面。 可以包含若干内容块' AUTO_INCREMENT=11 ;

-- 
-- 导出表中的数据 `my_page`
-- 

INSERT INTO `my_page` (`page_id`, `page_category_id`, `page_name`, `has_main_block`, `publish`, `show_level`, `template_id`, `support_type`, `notes`) VALUES (1, 1, 'news', 0, 1, 0, NULL, 1, '');
INSERT INTO `my_page` (`page_id`, `page_category_id`, `page_name`, `has_main_block`, `publish`, `show_level`, `template_id`, `support_type`, `notes`) VALUES (3, 1, 'ad_show', 1, 1, 0, 0, 7, '广告展示页面');
INSERT INTO `my_page` (`page_id`, `page_category_id`, `page_name`, `has_main_block`, `publish`, `show_level`, `template_id`, `support_type`, `notes`) VALUES (5, 2, 'left_ad', 1, 1, 0, 0, 127, '只有左侧有广告');
INSERT INTO `my_page` (`page_id`, `page_category_id`, `page_name`, `has_main_block`, `publish`, `show_level`, `template_id`, `support_type`, `notes`) VALUES (6, 2, 'right_ad', 1, 1, 0, 0, 0, '只有右侧有广告');
INSERT INTO `my_page` (`page_id`, `page_category_id`, `page_name`, `has_main_block`, `publish`, `show_level`, `template_id`, `support_type`, `notes`) VALUES (7, 2, 'sides_ad', 1, 1, 0, 0, 0, '两侧边栏有广告');
INSERT INTO `my_page` (`page_id`, `page_category_id`, `page_name`, `has_main_block`, `publish`, `show_level`, `template_id`, `support_type`, `notes`) VALUES (8, 2, 'myPage', 1, 1, 0, 0, 7, '');
INSERT INTO `my_page` (`page_id`, `page_category_id`, `page_name`, `has_main_block`, `publish`, `show_level`, `template_id`, `support_type`, `notes`) VALUES (9, 3, 'login', 0, 1, 0, 0, 7, '用户登录页面');
INSERT INTO `my_page` (`page_id`, `page_category_id`, `page_name`, `has_main_block`, `publish`, `show_level`, `template_id`, `support_type`, `notes`) VALUES (10, 3, 'home', 0, 1, 0, 3, 0, '首页');

-- --------------------------------------------------------

-- 
-- 表的结构 `my_page_category`
-- 

CREATE TABLE `my_page_category` (
  `page_category_id` int(4) NOT NULL auto_increment COMMENT '页面分类ID',
  `page_category_name` varchar(64) NOT NULL COMMENT '页面分类名称',
  PRIMARY KEY  (`page_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='定制页面分类表' AUTO_INCREMENT=4 ;

-- 
-- 导出表中的数据 `my_page_category`
-- 

INSERT INTO `my_page_category` (`page_category_id`, `page_category_name`) VALUES (1, '频道页面');
INSERT INTO `my_page_category` (`page_category_id`, `page_category_name`) VALUES (2, '广告页面');
INSERT INTO `my_page_category` (`page_category_id`, `page_category_name`) VALUES (3, '系统页面');

-- --------------------------------------------------------

-- 
-- 表的结构 `my_permission`
-- 

CREATE TABLE `my_permission` (
  `perm_id` tinyint(4) NOT NULL auto_increment COMMENT '权限ID',
  `perm_name` varchar(20) NOT NULL COMMENT '权限名',
  `perm_value` varchar(20) NOT NULL COMMENT '权限值',
  `module_id` tinyint(3) NOT NULL default '0' COMMENT '所属模块',
  PRIMARY KEY  (`perm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限列表' AUTO_INCREMENT=4 ;

-- 
-- 导出表中的数据 `my_permission`
-- 

INSERT INTO `my_permission` (`perm_id`, `perm_name`, `perm_value`, `module_id`) VALUES (1, 'browser', '1', 1);
INSERT INTO `my_permission` (`perm_id`, `perm_name`, `perm_value`, `module_id`) VALUES (2, 'add_comment', '1', 1);
INSERT INTO `my_permission` (`perm_id`, `perm_name`, `perm_value`, `module_id`) VALUES (3, 'vote', '1', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_position`
-- 

CREATE TABLE `my_position` (
  `position_id` tinyint(3) NOT NULL auto_increment COMMENT '位置ID',
  `position_name` varchar(20) NOT NULL COMMENT '位置名称',
  `note` varchar(200) default NULL COMMENT '备注',
  PRIMARY KEY  (`position_id`),
  UNIQUE KEY `position_name` (`position_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- 
-- 导出表中的数据 `my_position`
-- 

INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (1, 'head_menu', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (2, 'left_menu', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (3, 'right_menu', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (4, 'bottom_menu', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (5, 'banner', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (6, 'banner_right', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (10, 'right_block', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (9, 'left_block', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (11, 'body_banner', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (12, 'body_content', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (13, 'top_menu', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (7, 'logo', NULL);
INSERT INTO `my_position` (`position_id`, `position_name`, `note`) VALUES (14, 'page_foot', 'this position would be placed at the page bottom');

-- --------------------------------------------------------

-- 
-- 表的结构 `my_rank`
-- 

CREATE TABLE `my_rank` (
  `rank_id` tinyint(3) NOT NULL auto_increment,
  `rank_name` varchar(20) NOT NULL,
  `level` tinyint(2) NOT NULL,
  `desc` varchar(100) default NULL,
  PRIMARY KEY  (`rank_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限级别定义' AUTO_INCREMENT=8 ;

-- 
-- 导出表中的数据 `my_rank`
-- 

INSERT INTO `my_rank` (`rank_id`, `rank_name`, `level`, `desc`) VALUES (1, 'visitor', 0, NULL);
INSERT INTO `my_rank` (`rank_id`, `rank_name`, `level`, `desc`) VALUES (2, 'guest', 1, '访客');
INSERT INTO `my_rank` (`rank_id`, `rank_name`, `level`, `desc`) VALUES (3, 'registor', 2, '前台注册用户');
INSERT INTO `my_rank` (`rank_id`, `rank_name`, `level`, `desc`) VALUES (4, 'poster', 4, '发布网站内容人员');
INSERT INTO `my_rank` (`rank_id`, `rank_name`, `level`, `desc`) VALUES (5, 'censor', 5, '内容审核员');
INSERT INTO `my_rank` (`rank_id`, `rank_name`, `level`, `desc`) VALUES (6, 'captain', 6, '组管理员');
INSERT INTO `my_rank` (`rank_id`, `rank_name`, `level`, `desc`) VALUES (7, 'administrator', 7, '网站管理员');

-- --------------------------------------------------------

-- 
-- 表的结构 `my_roles`
-- 

CREATE TABLE `my_roles` (
  `role_id` int(4) NOT NULL auto_increment COMMENT '角色id， 在my_role_permission 表中对应',
  `role_name` varchar(250) NOT NULL COMMENT '角色名称',
  `rode_desc` text COMMENT '角色功能描述',
  PRIMARY KEY  (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统角色表' AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `my_roles`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `my_role_permission`
-- 

CREATE TABLE `my_role_permission` (
  `role_permission_id` int(8) NOT NULL auto_increment,
  `role_id` int(4) NOT NULL COMMENT '角色id ： #._role 表中的role_id',
  `permission_id` int(6) NOT NULL COMMENT '权限ID : #._permission 表中的 permission_id',
  PRIMARY KEY  (`role_permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色与权限匹配表' AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `my_role_permission`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `my_session`
-- 

CREATE TABLE `my_session` (
  `sid` char(32) NOT NULL COMMENT 'session id',
  `sess_data` text NOT NULL COMMENT 'session 值',
  `time_flg` bigint(10) NOT NULL COMMENT 'session更新时间',
  `uid` varchar(20) default NULL COMMENT '在线用户名',
  `user_id` int(8) default NULL COMMENT '用户ID',
  `request_type` tinyint(1) default NULL COMMENT '访问的页面类型： 1 首页， 2：页面， 4：模块',
  `request_type_id` int(4) default NULL COMMENT '访问类型id： 模块id， 页面id',
  `ip` varchar(15) default NULL COMMENT 'IP地址',
  `gid` tinyint(3) default NULL COMMENT '用户所在组ID',
  `rank` tinyint(1) default NULL COMMENT '用户级别',
  `is_admin` tinyint(1) default NULL COMMENT '是否是管理员',
  `is_super` tinyint(1) default NULL COMMENT '是否是超级用户',
  KEY `sid` (`sid`),
  KEY `time_flg` (`time_flg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- 导出表中的数据 `my_session`
-- 

INSERT INTO `my_session` (`sid`, `sess_data`, `time_flg`, `uid`, `user_id`, `request_type`, `request_type_id`, `ip`, `gid`, `rank`, `is_admin`, `is_super`) VALUES ('fe22b0e9d90fe82ee59d561eb1c2ce92', 'my_user|a:25:{s:7:"user_id";s:1:"2";s:3:"uid";s:5:"guest";s:3:"pwd";s:32:"084e0343a0486ff05530df6c705c8bb4";s:6:"gender";s:1:"1";s:3:"age";s:2:"30";s:5:"email";s:17:"wangkilin@126.com";s:3:"url";s:23:"http://www.yeaheasy.com";s:5:"photo";N;s:8:"reg_time";s:10:"1175906299";s:6:"reg_ip";s:9:"127.0.0.1";s:5:"theme";s:1:"0";s:11:"admin_theme";s:1:"0";s:8:"language";s:1:"0";s:10:"email_open";s:1:"0";s:8:"email_ad";s:1:"0";s:10:"last_login";s:10:"1175906299";s:7:"last_ip";s:9:"127.0.0.1";s:4:"rank";s:1:"0";s:5:"posts";s:1:"0";s:9:"group_ids";a:2:{i:0;s:1:"1";i:1;s:1:"2";}s:11:"system_user";s:1:"0";s:11:"super_admin";s:1:"0";s:3:"bak";s:6:"访客";s:4:"perm";a:0:{}s:11:"front_theme";s:12:"cloth_purple";}', 1284300136, '', 0, 0, 0, '127.0.0.1', 0, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_theme`
-- 

CREATE TABLE `my_theme` (
  `theme_id` int(11) NOT NULL auto_increment,
  `parent_id` int(4) NOT NULL default '0' COMMENT '父级ID。 如果有父级ID， 加载CSS时， 需要将父级CSS同时载入',
  `theme_name` varchar(20) NOT NULL,
  `theme_desc` varchar(30) NOT NULL COMMENT '使用此名称， 加载CSS （theme_name.css)',
  `css_name` varchar(80) NOT NULL COMMENT '使用此名称， 加载CSS （css_name.css)',
  `theme_path` varchar(40) NOT NULL COMMENT '模板路径',
  `template_name` varchar(80) NOT NULL default 'index.php' COMMENT '模板文件名称',
  `type` tinyint(1) NOT NULL default '0' COMMENT '模板类型 1：后台；0：前台。 前后台的模板路径会对应到各自的目录下',
  `content` text COMMENT '模板内容',
  `create_time` datetime NOT NULL COMMENT '主题加入系统的时间',
  `author_name` varchar(80) default NULL COMMENT '主题作者名字',
  `author_url` varchar(255) default NULL COMMENT '主题作者网址',
  PRIMARY KEY  (`theme_id`),
  KEY `theme_name` (`theme_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- 导出表中的数据 `my_theme`
-- 

INSERT INTO `my_theme` (`theme_id`, `parent_id`, `theme_name`, `theme_desc`, `css_name`, `theme_path`, `template_name`, `type`, `content`, `create_time`, `author_name`, `author_url`) VALUES (1, 0, 'kinful', 'yeaheasy front theme', '', 'kinful', 'index.php', 0, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO `my_theme` (`theme_id`, `parent_id`, `theme_name`, `theme_desc`, `css_name`, `theme_path`, `template_name`, `type`, `content`, `create_time`, `author_name`, `author_url`) VALUES (2, 0, 'kinful', 'yeaheasy admin theme', '', 'kinful', 'index.php', 1, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO `my_theme` (`theme_id`, `parent_id`, `theme_name`, `theme_desc`, `css_name`, `theme_path`, `template_name`, `type`, `content`, `create_time`, `author_name`, `author_url`) VALUES (3, 0, 'clothes', '童装模板', 'clothes', 'clothes', 'index.php', 0, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO `my_theme` (`theme_id`, `parent_id`, `theme_name`, `theme_desc`, `css_name`, `theme_path`, `template_name`, `type`, `content`, `create_time`, `author_name`, `author_url`) VALUES (4, 0, 'cloth_purple', '童装紫色模板', 'cloth_purple', 'cloth_purple', 'index.php', 0, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO `my_theme` (`theme_id`, `parent_id`, `theme_name`, `theme_desc`, `css_name`, `theme_path`, `template_name`, `type`, `content`, `create_time`, `author_name`, `author_url`) VALUES (5, 0, 'it_tech', '', '', 'it_tech', 'index.php', 0, NULL, '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_translation`
-- 

CREATE TABLE `my_translation` (
  `translation_type` tinyint(1) NOT NULL COMMENT '是模块的翻译还是频道的翻译',
  `translation_type_id` int(4) NOT NULL COMMENT '频道或者模块的ID',
  `translation_language` tinyint(2) NOT NULL COMMENT '语言类型',
  `key_word` varchar(64) NOT NULL COMMENT '翻译的关键字',
  `translation` text NOT NULL COMMENT '翻译内容',
  PRIMARY KEY  (`translation_type`,`translation_type_id`,`translation_language`,`key_word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='翻译表';

-- 
-- 导出表中的数据 `my_translation`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `my_user`
-- 

CREATE TABLE `my_user` (
  `user_id` int(8) NOT NULL auto_increment COMMENT '用户ID',
  `uid` char(40) NOT NULL COMMENT '用户名',
  `pwd` char(32) NOT NULL COMMENT '密码',
  `gender` tinyint(1) NOT NULL COMMENT '性别',
  `age` tinyint(3) NOT NULL COMMENT '年龄',
  `email` varchar(60) default NULL COMMENT 'email',
  `url` varchar(250) default NULL COMMENT '主页',
  `photo` varchar(250) default NULL COMMENT '照片',
  `reg_time` bigint(10) NOT NULL COMMENT '注册时间',
  `reg_ip` varchar(15) NOT NULL COMMENT '注册IP',
  `theme` tinyint(2) NOT NULL COMMENT '使用模板',
  `admin_theme` int(4) NOT NULL COMMENT '后台模板',
  `language` tinyint(2) NOT NULL default '0' COMMENT '用户选择的浏览语言',
  `email_open` tinyint(1) NOT NULL COMMENT 'email是否开放',
  `email_ad` tinyint(1) NOT NULL COMMENT '是否接受email广告',
  `last_login` bigint(10) NOT NULL COMMENT '上次登陆时间',
  `last_ip` varchar(15) NOT NULL COMMENT '上次登陆IP',
  `rank` tinyint(2) NOT NULL COMMENT '级别',
  `posts` int(8) NOT NULL COMMENT '发表文章数量',
  `group_ids` varchar(250) default NULL COMMENT '所属组',
  `system_user` tinyint(1) NOT NULL default '0' COMMENT 'is system user',
  `super_admin` tinyint(1) NOT NULL default '0' COMMENT 'is super administrator',
  `bak` varchar(40) default NULL,
  PRIMARY KEY  (`user_id`),
  KEY `uid` (`uid`),
  KEY `pwd` (`pwd`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `my_user`
-- 

INSERT INTO `my_user` (`user_id`, `uid`, `pwd`, `gender`, `age`, `email`, `url`, `photo`, `reg_time`, `reg_ip`, `theme`, `admin_theme`, `language`, `email_open`, `email_ad`, `last_login`, `last_ip`, `rank`, `posts`, `group_ids`, `system_user`, `super_admin`, `bak`) VALUES (1, 'wangkilin', 'bd019bbc007ba41ceda5da58bf07f941', 1, 30, 'wangkilin@126.com', 'http://www.yeaheasy.com', NULL, 1175906299, '127.0.0.1', 1, 0, 0, 0, 0, 1175906299, '127.0.0.1', 2, 2, ',2,', 1, 1, NULL);
INSERT INTO `my_user` (`user_id`, `uid`, `pwd`, `gender`, `age`, `email`, `url`, `photo`, `reg_time`, `reg_ip`, `theme`, `admin_theme`, `language`, `email_open`, `email_ad`, `last_login`, `last_ip`, `rank`, `posts`, `group_ids`, `system_user`, `super_admin`, `bak`) VALUES (2, 'guest', '084e0343a0486ff05530df6c705c8bb4', 1, 30, 'wangkilin@126.com', 'http://www.yeaheasy.com', NULL, 1175906299, '127.0.0.1', 4, 0, 0, 0, 0, 1175906299, '127.0.0.1', 0, 0, ',1,2,', 0, 0, '访客');

-- --------------------------------------------------------

-- 
-- 表的结构 `my_user_message`
-- 

CREATE TABLE `my_user_message` (
  `to_user_id` int(8) NOT NULL COMMENT '发送到用户ID',
  `from_user_id` int(8) NOT NULL COMMENT '来自于用户ID',
  `from_uid` varchar(40) NOT NULL COMMENT '来自于uid',
  `msg_time` bigint(10) NOT NULL COMMENT '收到时间',
  `has_read` tinyint(1) NOT NULL default '0' COMMENT '是否已读',
  `message` varchar(400) NOT NULL COMMENT '消息内容',
  `has_reply` tinyint(1) NOT NULL COMMENT '是否已回复',
  KEY `to_user_id` (`to_user_id`),
  KEY `msg_time` (`msg_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站内消息表';

-- 
-- 导出表中的数据 `my_user_message`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `my_using_block`
-- 

CREATE TABLE `my_using_block` (
  `using_block_id` int(6) NOT NULL auto_increment,
  `block_id` int(6) NOT NULL,
  `more_params` text COMMENT '更多的参数列表：同一个显示块，加入不同的参数，得到更多的显示效果',
  `show_in_type` mediumint(3) NOT NULL default '255' COMMENT '在哪些页面显示： 255-所有页面， 2-在指定的页面， 4-排除指定的页面',
  `show_in_condition` varchar(400) default NULL COMMENT '保存文件名。 此文件为php代码文件。 代码将在函数中执行。 只有返回true，才会显示',
  `block_show_name` varchar(80) default NULL COMMENT '块名',
  `show_block_name` tinyint(1) NOT NULL default '0' COMMENT '是否显示块标题',
  `position_id` int(4) NOT NULL COMMENT '位置ID',
  `access_roles` varchar(400) default NULL COMMENT '哪些角色能看到：角色Id列表， 逗号分隔',
  `publish` tinyint(1) NOT NULL default '1',
  `note` varchar(255) default NULL COMMENT '备注信息',
  `order` tinyint(2) NOT NULL default '0' COMMENT '显示的顺序',
  `block_link` varchar(255) default NULL COMMENT '块标题的链接地址',
  `show_link` tinyint(1) NOT NULL default '0' COMMENT '是否显示连接地址',
  `block_link_target` varchar(40) default NULL COMMENT '块链接显示的目的页。 a target=''***''',
  `attach_text` varchar(80) default NULL COMMENT '附加信息',
  `attach_link` varchar(255) default NULL COMMENT '附加信息链接地址',
  `attach_link_target` varchar(40) default NULL COMMENT '块附加链接显示的目的页。 a target=''***''',
  PRIMARY KEY  (`using_block_id`),
  KEY `block_id` (`block_id`),
  KEY `position_id` (`position_id`),
  KEY `show_in_type` (`show_in_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='页面中调用的块' AUTO_INCREMENT=29 ;

-- 
-- 导出表中的数据 `my_using_block`
-- 

INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (1, 1, NULL, 4, NULL, 'login', 0, 1, '0', 1, '', 0, '', 0, NULL, '', '', NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (2, 1, NULL, 4, NULL, 'login_1', 0, 2, '0', 1, '', 0, '', 0, NULL, '', '', NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (3, 2, NULL, 4, NULL, 'system_login', 0, 2, '0', 1, '', 0, '', 0, NULL, '系统登录', 'http://www.zhidianmijin.com', NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (4, 3, NULL, 4, NULL, 'system_logo', 1, 2, '0', 1, '', 0, '', 0, NULL, '', '', NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (5, 4, NULL, 4, NULL, 'system_banner', 0, 5, '0', 1, '', 0, '', 0, NULL, '', '', NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (6, 5, NULL, 4, NULL, 'channels', 0, 6, '0', 1, '', 0, '', 0, NULL, '', '', NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (7, 6, NULL, 2, NULL, 'menus', 1, 2, '0', 1, '', 0, '', 0, NULL, '', '', NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (8, 7, NULL, 255, NULL, 'admin_menu', 0, 1, '0', 1, '', 0, '', 0, NULL, '', '', NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (14, 6, NULL, 2, NULL, 'menu', 0, 11, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (20, 3, NULL, 2, NULL, 'logo', 0, 7, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (15, 6, NULL, 2, NULL, 'menu', 0, 12, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (16, 6, NULL, 2, NULL, 'menu', 0, 4, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (17, 6, NULL, 2, NULL, 'menu', 0, 3, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (18, 6, NULL, 2, NULL, 'menu', 0, 13, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (21, 8, NULL, 2, NULL, '随机新闻', 0, 12, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (22, 9, NULL, 2, NULL, '同类新闻展示', 0, 9, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (27, 11, NULL, 255, NULL, 'front_head_menu', 0, 1, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (25, 8, 'category_id=3\r\nshowItemsCount=2', 2, NULL, 'randomNews', 0, 10, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (26, 10, 'showItemsCount=5', 2, NULL, 'getLatestNews', 0, 9, '0', 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `my_using_block` (`using_block_id`, `block_id`, `more_params`, `show_in_type`, `show_in_condition`, `block_show_name`, `show_block_name`, `position_id`, `access_roles`, `publish`, `note`, `order`, `block_link`, `show_link`, `block_link_target`, `attach_text`, `attach_link`, `attach_link_target`) VALUES (28, 5, NULL, 255, NULL, 'bg_music', 0, 14, NULL, 1, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

-- 
-- 表的结构 `my_using_block_page`
-- 

CREATE TABLE `my_using_block_page` (
  `using_page_id` int(8) NOT NULL auto_increment,
  `using_block_id` int(8) NOT NULL COMMENT '外键： 指向#_using_block ',
  `page_id` int(6) NOT NULL COMMENT '外键： 指向 #_page',
  PRIMARY KEY  (`using_page_id`),
  KEY `using_block_id` (`using_block_id`),
  KEY `page_id` (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='显示块指定显示的页面， 或者指定不显示的页面' AUTO_INCREMENT=30 ;

-- 
-- 导出表中的数据 `my_using_block_page`
-- 

INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (1, 7, 1);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (2, 7, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (14, 4, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (9, 14, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (10, 15, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (11, 16, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (12, 17, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (13, 18, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (16, 20, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (17, 5, 9);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (18, 1, 9);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (19, 2, 9);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (20, 6, 9);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (21, 21, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (22, 22, 8);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (27, 3, 0);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (25, 25, 0);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (26, 26, 0);
INSERT INTO `my_using_block_page` (`using_page_id`, `using_block_id`, `page_id`) VALUES (29, 28, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `order`
-- 

CREATE TABLE `order` (
  `company_china` varchar(120) NOT NULL default '',
  `company_english` varchar(120) NOT NULL default '',
  `contact_person` varchar(40) NOT NULL default '',
  `tel` varchar(20) NOT NULL default '',
  `email` varchar(30) NOT NULL default '',
  `post_code` varchar(10) NOT NULL default '',
  `addr` varchar(200) NOT NULL default '',
  `site_name` varchar(100) NOT NULL default '',
  `style` text NOT NULL,
  `color` varchar(10) NOT NULL default '',
  `color_more` varchar(40) NOT NULL default '',
  `text_size` varchar(10) NOT NULL default '',
  `database` varchar(5) NOT NULL default '',
  `pix` varchar(12) NOT NULL default '',
  `homepage` char(3) NOT NULL default '',
  `logo` char(3) NOT NULL default '',
  `friend_link` char(3) NOT NULL default '',
  `ad` char(3) NOT NULL default '',
  `contact` char(3) NOT NULL default '',
  `more` char(3) NOT NULL default '',
  `link_content` text NOT NULL,
  `link_other` text NOT NULL,
  `site_1` varchar(40) NOT NULL default '',
  `site_2` varchar(40) NOT NULL default '',
  `site_3` varchar(40) NOT NULL default '',
  `site_4` varchar(40) NOT NULL default '',
  `date` varchar(80) NOT NULL default '',
  `price` varchar(20) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- 导出表中的数据 `order`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `table_str`
-- 

CREATE TABLE `table_str` (
  `table` varchar(30) NOT NULL default '',
  `field` varchar(30) NOT NULL default '',
  `detail` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- 导出表中的数据 `table_str`
-- 

INSERT INTO `table_str` (`table`, `field`, `detail`) VALUES ('item', 'parent_id', '父目录的id');
INSERT INTO `table_str` (`table`, `field`, `detail`) VALUES ('item', 'list_id', '各个频道显示的顺序号码');
INSERT INTO `table_str` (`table`, `field`, `detail`) VALUES ('item', 'title', '频道的标题');
INSERT INTO `table_str` (`table`, `field`, `detail`) VALUES ('item', 'cotent', '频道内容');
INSERT INTO `table_str` (`table`, `field`, `detail`) VALUES ('item', 'is_show', '频道是否可以浏览');
