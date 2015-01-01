# $Id: mambo.sql,v 1.96 2004/09/24 18:08:09 rcastley Exp $

#
# Table structure for table `#__banner`
#

CREATE TABLE `#__banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default 'banner',
  `name` varchar(50) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `custombannercode` text,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `#__banner`
#

# --------------------------------------------------------

#
# Table structure for table `#__bannerclient`
#

CREATE TABLE `#__bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) TYPE=MyISAM;

#
# Dumping data for table `#__bannerclient`
#

# --------------------------------------------------------

#
# Table structure for table `#__bannerfinish`
#

CREATE TABLE `#__bannerfinish` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(10) NOT NULL default '',
  `name` varchar(50) NOT NULL default '',
  `impressions` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(50) NOT NULL default '',
  `datestart` datetime default NULL,
  `dateend` datetime default NULL,
  PRIMARY KEY  (`bid`)
) TYPE=MyISAM;

#
# Dumping data for table `#__bannerfinish`
#

# --------------------------------------------------------

#
# Table structure for table `#__categories`
#

CREATE TABLE `#__categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default 0,
  `title` varchar(50) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `image` varchar(100) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_section` (`section`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) TYPE=MyISAM;

#
# Dumping data for table `#__categories`
#
INSERT INTO `#__categories` VALUES (1, 0, '最新消息', '最新消息', 'taking_notes.jpg', '1', 'left', '本站最新动态', 1, 0, '0000-00-00 00:00:00', '', 0, 0, 1, '');
INSERT INTO `#__categories` VALUES (2, 0, 'Mambo相关站点', 'Mambo相关站点', 'clock.jpg', 'com_weblinks', 'left', 'Mambo相关站点', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, '');
INSERT INTO `#__categories` VALUES (3, 0, '热点新闻', '热点新闻', '', '2', 'left', '', 1, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '');
INSERT INTO `#__categories` VALUES (4, 0, '联系方式', '联系方式', '', 'com_contact_details', 'left', '本站相关联系方式', 1, 0, '0000-00-00 00:00:00', NULL, 0, 0, 0, '');
INSERT INTO `#__categories` VALUES (66, 0, 'Mambo', 'Mambo', '', 'com_newsfeeds', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 2, 0, 0, '');
# --------------------------------------------------------

#
# Table structure for table `#__components`
#

CREATE TABLE `#__components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__components`
#

INSERT INTO `#__components` VALUES (1, '横幅广告', '', 0, 0, '', '横幅广告管理', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (2, '管理横幅广告', '', 0, 1, 'option=com_banners', '活路的横幅广告', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `#__components` VALUES (3, '管理广告客户', '', 0, 1, 'option=com_banners&task=listclients', '管理广告客户', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `#__components` VALUES (4, '网站链接', 'option=com_weblinks', 0, 0, '', '管理网站链接', 'com_weblinks', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (5, '网站链接条目', '', 0, 4, 'option=com_weblinks', '查看已有链接', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `#__components` VALUES (6, '网站链接分类', '', 0, 4, 'option=categories&section=com_weblinks', '管理网站链接分类', '', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `#__components` VALUES (7, '联系人', 'option=com_contact', 0, 0, '', '编辑联系人资料', 'com_contact', 0, 'js/ThemeOffice/component.png', 1, '');
INSERT INTO `#__components` VALUES (8, '管理联系人', '', 0, 7, 'option=com_contact', '编辑联系人资料', 'com_contact', 0, 'js/ThemeOffice/component.png', 1, '');
INSERT INTO `#__components` VALUES (9, '联系人分类', '', 0, 7, 'option=categories&section=com_contact_details', '管理联系人分类', '', 2, 'js/ThemeOffice/categories.png', 1, '');
INSERT INTO `#__components` VALUES (10, '首页', 'option=com_frontpage', 0, 0, '', '管理首页显示条目', 'com_frontpage', 0, 'js/ThemeOffice/component.png', 1, '');
INSERT INTO `#__components` VALUES (11, '在线调查', 'option=com_poll', 0, 0, 'option=com_poll', '管理在线调查', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (12, '新闻导入', 'option=com_newsfeeds', 0, 0, '', '新闻导入管理', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '');
INSERT INTO `#__components` VALUES (13, '管理新闻导入', '', 0, 12, 'option=com_newsfeeds', '管理新闻导入', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, '');
INSERT INTO `#__components` VALUES (14, '管理新闻导入分类', '', 0, 12, 'option=com_categories&section=com_newsfeeds', '管理新闻导入分类', '', 2, 'js/ThemeOffice/categories.png', 0, '');
INSERT INTO `#__components` VALUES (15, '登录', 'option=com_login', 0, 0, '', '', 'com_login', 0, '', 1, '');
INSERT INTO `#__components` VALUES (16, '站内搜索', 'option=com_search', 0, 0, '', '', 'com_search', 0, '', 1, '');
INSERT INTO `#__components` VALUES (17, '新闻联合','',0,0,'option=com_syndicate','管理网站新闻联合','com_syndicate',0,'js/ThemeOffice/component.png',0,'');
# --------------------------------------------------------

#
# Table structure for table `#__contact_details`
#

CREATE TABLE `#__contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `con_position` varchar(50) default NULL,
  `address` text,
  `suburb` varchar(50) default NULL,
  `state` varchar(20) default NULL,
  `country` varchar(50) default NULL,
  `postcode` varchar(10) default NULL,
  `telephone` varchar(25) default NULL,
  `fax` varchar(25) default NULL,
  `misc` mediumtext,
  `image` varchar(100) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(100) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__contact_details`
#

INSERT INTO `#__contact_details` VALUES (1, '姓名', '职位', '地址', '地区', '省份', '国家', '邮编', '电话', '传真', '更多信息', 'asterisk.png', 'top', 'email@email.com', 1, 1, 0, '0000-00-00 00:00:00', 1, '', 0, 4, 0);# --------------------------------------------------------

#
# Table structure for table `#__content`
#

CREATE TABLE `#__content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `title_alias` varchar(100) NOT NULL default '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(11) unsigned NOT NULL default '0',
  `mask` int(11) unsigned NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL default '0',
  `created_by_alias` varchar(100) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL default '1',
  `parentid` int(11) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_mask` (`mask`)
) TYPE=MyISAM;


#
# Dumping data for table `#__content`
#
INSERT INTO `#__content` VALUES (1, '什么是Mambo智能建站系统(CMS)？', 'Mambo简介', '欢迎转载，转载请注明出处：Mambo中国http://www.mambochina.net<br /><br />Mambo，中文意思为曼波音乐(源于古巴黑人音乐)，是这个星球上功能最强大的开放源码的智能建站系统之一。在2004年4月20日伦敦举行的Linux用户和开发员大会上，Mambo从众多优秀的开放源码系统中脱颖而出，获得2004年度最佳Linux开放源码系统奖项，和它同场竞技的有KDE、Firebird SQL以及eGroupware等，这些都是知名度很高，被广泛使用的系统，现在却沦为Mambo的手下败将，可想而知，Mambo的魔力有多大！<br /><br />Mambo是功能非常强大的智能建站系统，目前用户快超过了Phpnuke,他吸收了phpnuke,xoops的很多优点，更灵活，更强大，有数不清的插件和皮肤下载！<br /><br />本文将给你一个较好的解释，Mambo是如何适合网站建设和管理的。', 'Mambo究竟是什么东东！<br /><br />首先也是最重要的，Mambo是一个网站智能建站系统(CMS)，它是网站的后台引擎，使网站内容的创建、管理和共享更加简易。<br /><br />主要特点：<br /><br />强大源自简易！这是Mambo的口号 power in simplicity!<br />源码完全开放和免费。<br />有一个大而健全的用户和开发员社区。 <br />提供基本的内容审核机制，来审核注册用户发表的内容。<br />提供页面缓冲机制，提高大访问量网站的性能。<br />回收站管理器。<br />广告管理 (例如：旗帜广告)。<br />多媒体 (图片，文件) 上传和管理 。<br />内容显示可以自定义排序。<br />内容联合显示 (RSS)。<br />搜索引擎友好 (SEF) 网址模式，把动态网址显示成静态模式，让搜索蜘蛛更容易抓取网站内容。<br />国际化 (界面翻译)。<br />内容支持宏语言。<br />先进且分离的系统管理后台。 <br />先进的 “组件/模块/界面模版”安装部署机制。<br />简单且强大的界面模版机制 (大部分都用 HTML 来写，没有复杂的语法，只需用几个 PHP 函数来include)。 <br />按等级进行用户组权限控制<br />基本的访客统计功能。 <br />支持多种 WYSIWYG 所见即所得的内容编辑器。<br />简单的调查系统。<br />内容投票/评分系统。 <br />另外还有很多实用的插件在Mambo开发中心http://www.mamboforge.net中，主要有：<br /><br />LDAP 认证 <br />扩展的用户资料管理 <br />论坛 <br />图库 <br />文件下载管理 <br />界面模版 <br />日历<br />... ... 还有很多<br /><br />Mambo不是什么东东！<br /><br />Mambo不是大型的“门户”网站解决方案。<br /><br />虽然通过对Mambo进行修改和扩展，也可以用来建设大型门户网站，但这个不是Mambo的目的所在。Mambo主要面向公司网站、中小型商务网站、家庭和个人网站。<br /><br />Mambo开发团队致力于构建一个可靠的应用框架，而不是构建应用插件，而插件在很多门户网站方案中很常见。这条原则使得Mambo核心非常轻巧和高效，更容易让第三方在Mambo的基础上定制组件和模块，直接满足他们的需要。', 1, 1, 0, 1, '2004-09-25 11:54:06', 62, 'Web Master', '2004-09-25 21:05:15', 62, 0, '0000-00-00 00:00:00', '2004-09-25 00:00:00', '0000-00-00 00:00:00', 'asterisk.png|left|Another logo|0', '', 'pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=', 2, 0, 1, '', '', 0, 1);
INSERT INTO `#__content` VALUES (2, 'Mambo适合我吗？', '', '　　翻译：zhous　Mambo中国<br />　　原文：Is Mambo for me? 来自Mambo官方网站<br /><br />　　这里我们提供一些精短的意见作为您评价Mambo前的参考，帮助您挑选到最适合于您的内容管理系统（CMS）。<br />　　当您看到这篇内容时，也许您为了找到最好的内容管理系统（CMS）而已经在网上寻觅了几个小时甚至几天。如果是这样，那么您其实可能还仅仅是刚开始您的掘宝之旅。', '　　究竟凭什么正确判断一个CMS是您所需的最好的CMS呢？下面是帮助您回答这一问题的参考意见：<br />　　1、http://mamboforge.net/demo这是Mambo的演示网站。<br />　　2、www.cmsmatrix.org在这个网站您可以对最流行的或者不为人知的众多内容管理系统进行平行比较。<br />　　3、www.opensourcecms.com这是一个收集了很多众多内容管理及其演示的著名网站<br /><br />　　仅仅观看一下演示而对某一个内容管理系统产生较好的印象是不是就够了？<br />　　我们认为是远远不够的。您应该在了解清楚以下情况之后再决定采用最适合于您的内容管理系统：<br />　　1、该内容管理系统是否有一个健全的开发团队提供核心技术支持？<br />　　2、该内容管理系统是否有一个健全的开发团体为用户提供丰富的插件、模板等等？（开发团体是指核心开发人员以外的志愿性开发组织或个人）<br />　　3、该内容管理系统是否有一个健全的可以为系统的持续发展提供动力、帮助和支持的用户群体？<br />　　我们很高兴的是Mambo完美地集合了这三个要素。<br /><br />　　下面的建议可以进一步帮助您比较不同的内容管理系统：<br />　　1、在下载之前先留心一下它是不是一个能够及时更新的系统，它是不是最新的版本（对于Mambo您不妨去这里看看：http://mamboforge.net/projects/mambo/）。<br />　　2、检查一下是否有提供高质量客户支持和新闻的交流网站（对于Mambo您可以去http://mamboforge.net 看看，或者您也可以直接在搜索引挈里通过关键词“Mambo CMS”进行搜索）。<br />　　3、检查一下是否有供用户寻求帮助和交流心得体会的论坛或其它互动媒介（对于Mambo您可以去http://forum.mamboserver.com）<br /><br />　　我们衷心希望您能够顺利找到您所需要的内容管理系统。刚刚获得2004年度最佳Linux开放源码系统奖的Mambo毫无疑问是一个了不起的内容管理系统。我们觉得它还说不上完美，不过我们一定会让它得到不断的提高。', 1, 1, 0, 3, '2004-09-25 08:30:34', 62, '', '2004-09-25 21:06:28', 62, 0, '0000-00-00 00:00:00', '2004-09-25 00:00:00', '0000-00-00 00:00:00', '', '', 'pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=', 2, 0, 1, '', '', 0, 1);
INSERT INTO `#__content` VALUES (3, 'Mambo 4.5.1正式版发布了！', '', '　　一个特别令人振奋的消息，期待已久的Mambo 4.5.1稳定版，在经过４个Beta测试版和4个RC候选版的漫长锤炼之后，今天，2004年9月24日，终于发布了！<br /><br />　　Mambo 4.5.1稳定版修正了Beta版和RC候选版中发现的所有Bugs，增加了许多功能，使Mambo的性能和稳定性大幅提高，完全可以胜任多种类型的商务网站、个人网站的应用。<br /><br />　　目前官方发布的Mambo 4.5.1稳定版为英文界面，前台界面的汉化工作已由Mambo中国完成，欢迎下载使用；后台界面的汉化工作正在紧锣密鼓的进行当中，敬请关注！', '', 1, 2, 0, 3, '2004-09-25 08:30:34', 62, '', '2004-09-25 21:07:29', 62, 0, '0000-00-00 00:00:00', '2004-09-25 00:00:00', '0000-00-00 00:00:00', '', '', 'pageclass_sfx=\nback_button=\nitem_title=1\nlink_titles=\nintrotext=1\nsection=0\nsection_link=0\ncategory=0\ncategory_link=0\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=', 2, 0, 2, '', '', 0, 0);
INSERT INTO `#__content` VALUES (4, 'Newsflash 3', '', 'Aoccdrnig to a rscheearch at an Elingsh uinervtisy, it deosn\'t mttaer in waht oredr the ltteers in a wrod are, the olny iprmoetnt tihng is taht frist and lsat ltteer is at the rghit pclae. The rset can be a toatl mses and you can sitll raed it wouthit porbelm. Tihs is bcuseae we do not raed ervey lteter by itslef but the wrod as a wlohe.', '', -2, 2, 1, 3, '2004-08-09 08:30:34', 62, '', '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', '2004-08-09 00:00:00', '0000-00-00 00:00:00', '', '', '', 1, 0, 0, '', '', 0, 0);
INSERT INTO `#__content` VALUES (11, 'Mambo使用许可协议', '', '<font size="2"> <br />GNU通用公共许可证(<B style=\'color:black;background-color:#ffff66\'>GPL</B>)</font><br /><p><font size="2">GNU通用公共许可证<br /><br />1991.6 第二版</font><br /><p><font size="2">版权所有（C）1989，1991 Free Software foundation, Inc.<br /><br />675 Mass Ave, Cambridge, MA02139, USA<br /><br />允许每个人复制和发布这一许可证原始文档的副本，但绝对不允许对它进行任何修改。</font><br /><p><font size="2">序言</font><br /><p><font size="2"> <br />大多数软件许可证决意剥夺你的共享和修改软件的自由。对比之下，GNU通用公共许可证力图保证你的共享和修改自由软件的自由。——保证自由软件对所有用户是自由的。<B style=\'color:black;background-color:#ffff66\'>GPL</B>适用于大多数自由软件基金会的软件，以及由使用这些软件而承担义务的作者所开发的软件。（自由软件基金会的其他一些软件受GNU库通用许可证的保护）。你也可以将它用到你的程序中。当我们谈到自由软件（free <br />software）时，我们指的是自由而不是价格。<br /><br /> 我们的GNU通用公共许可证决意保证你有发布自由软件的自由（如果你愿意，你可以对此项服务收取一定的费用）；保证你能收到源程序或者在你需要时能得到它；保证你能修改软件或将它的一部分用于新的自由软件；而且还保证你知道你能做这些事情。<br /><br /> <br />为了保护你的权利，我们需要作出规定：禁止任何人不承认你的权利，或者要求你放弃这些权利。如果你修改了自由软件或者发布了软件的副本，这些规定就转化为你的责任。<br /><br /> <br />例如，如果你发布这样一个程序的副本，不管是收费的还是免费的，你必须将你具有的一切权利给予你的接受者；你必须保证他们能收到或得到源程序；并且将这些条款给他们看，使他们知道他们有这样的权利。<br /><br /> 我们采取两项措施来保护你的权利。<br /><br />（1）给软件以版权保护。<br /><br />（2）给你提供许可证。它给你复制，发布和修改这些软件的法律许可。<br /><br /> <br />同样，为了保护每个作者和我们自己，我们需要清楚地让每个人明白，自由软件没有担保（no <br />warranty）。如果由于其他某个人修改了软件，并继续加以传播。我们需要它的接受者明白：他们所得到的并不是原来的自由软件。由其他人引入的任何问题，不应损害原作者的声誉。<br /><br /> <br />最后，任何自由软件不断受到软件专利的威胁。我们希望避免这样的风险，自由软件的再发布者以个人名义获得专利许可证。事实上，将软件变为私有。为防止这一点，我们必须明确：任何专利必须以允许每个人自由使用为前提，否则就不准许有专利。<br /><br /> <br />下面是有关复制，发布和修改的确切的条款和条件。</font><br /><p><font size="2"><br /><br />GNU通用公共许可证<br /><br />有关复制，发布和修改的条款和条件</font><br /><p><font size="2">0. <br />此许可证适用于任何包含版权所有者声明的程序和其他作品，版权所有者在声明中明确说明程序和作品可以在<B style=\'color:black;background-color:#ffff66\'>GPL</B>条款的约束下发布。下面提到的“程序”指的是任何这样的程序或作品。而“基于程序的作品”指的是程序或者任何受版权法约束的衍生作品。也就是说包含程序或程序的一部分的作品。可以是原封不动的，或经过修改的和／或翻译成其他语言的（程序）。在下文中，翻译包含在修改的条款中。每个许可证接受人（licensee）用你来称呼。许可证条款不适用于复制，发布和修改以外的活动。这些活动超出这些条款的范围。运行程序的活动不受条款的限止。仅当程序的输出构成基于程序作品的内容时，这一条款才适用（如果只运行程序就无关）。是否普遍适用取决于程序具体用来做什么。</font><br /><p><font size="2">1. <br />只要你在每一副本上明显和恰当地出版版权声明和不 <br />械５１５ <br />声明，保持此许可证的声明和没有担保的声明完整无损，并和程序一起给每个其他的程序接受者一份许可证的副本，你就可以用任何媒体复制和发布你收到的原始的程序的源代码。你可以为转让副本的实际行动收取一定费用。你也有权选择提供担保以换取一定的费用。</font><br /><p><font size="2">2. <br />你可以修改程序的一个或几个副本或程序的任何部分，以此形成基于程序的作品。只要你同时满足下面的所有条件，你就可以按前面第一款的要求复制和发布这一经过修改的程序或作品。<br /><br />a） <br />你必须在修改的文件中附有明确的说明：你修改了这一文件及具体的修改日期。<br /><br />b） <br />你必须使你发布或出版的作品（它包含程序的全部或一部分，或包含由程序的全部或部分衍生的作品）允许第三方作为整体按许可证条款免费使用。<br /><br />c） <br />如果修改的程序在运行时以交互方式读取命令，你必须使它在开始进入常规的交互使用方式时打印或显示声明：包括适当的版权声明和没有担保的声明（或者你提供担保的声明）；用户可以按此许可证条款重新发布程序的说明；并告诉用户如何看到这一许可证的副本。（例外的情况：如果原始程序以交互方式工作，它并不打印这样的声明，你的基于程序的作品也就不用打印声明）。<br /><br /> <br />这些要求适用于修改了的作品的整体。如果能够确定作品的一部分并非程序的衍生产品，可以合理地认为这部分是独立的，是不同的作品。当你将它作为独立作品发布时，它不受此许可证和它的条款的约束。但是当你将这部分作为基于程序的作品的一部分发布时，作为整体它将受到许可证条款约束。准予其他许可证持有人的使用范围扩大到整个产品。也就是每个部分，不管它是谁写的。因此，本条款的意图不在于索取权利；或剥夺全部由你写成的作品的权利。而是履行权利来控制基于程序的集体作品或衍生作品的发布。此外，将与程序无关的作品和该程序或基于程序的作品一起放在存贮体或发布媒体的同一卷上，并不导致将其他作品置于此许可证的约束范围之内。</font><br /><p><font size="2">3. <br />你可以以目标码或可执行形式复制或发布程序（或符合第2款的基于程序的作品)，只要你遵守前面的第1，2款，并同时满足下列3条中的1条。<br /><br />a）在通常用作软件交换的媒体上，和目标码一起附有机器可读的完整的源码。这些源码的发布应符合上面第1，2款的要求。或者<br /><br />b）在通常用作软件交换的媒体上，和目标码一起，附有给第三方提供相应的机器可读的源码的书面报价。有效期不少于3年，费用不超过实际完成源程序发布的实际成本。源码的发布应符合上面的第1，2款的要求。或者<br /><br />c）和目标码一起，附有你收到的发布源码的报价信息。（这一条款只适用于非商业性发布，而且你只收到程序的目标码或可执行代码和按b）款要求提供的报价）。作品的源码指的是对作品进行修改最优先择取的形式。对可执行的作品讲，完整的源码包括：所有模块的所有源程序，加上有关的接口的定义，加上控制可执行作品的安装和编译的script。作为特殊例外，发布的源码不必包含任何常规发布的供可执行代码在上面运行的操作系统的主要组成部分（如编译程序，内核等）。除非这些组成部分和可执行作品结合在一起。如果采用提供对指定地点的访问和复制的方式发布可执行码或目标码，那么，提供对同一地点的访问和复制源码可以算作源码的发布，即使第三方不强求与目标码一起复制源码。</font><br /><p><font size="2">4. <br />除非你明确按许可证提出的要求去做，否则你不能复制，修改，转发许可证和发布程序。任何试图用其他方式复制，修改，转发许可证和发布程序是无效的。而且将自动结束许可证赋予你的权利。然而，对那些从你那里按许可证条款得到副本和权利的人们，只要他们继续全面履行条款，许可证赋予他们的权利仍然有效。</font><br /><p><font size="2">5. <br />你没有在许可证上签字，因而你没有必要一定接受这一许可证。然而，没有任何其他东西赋予你修改和发布程序及其衍生作品的权利。如果你不接受许可证，这些行为是法律禁止的。因此，如果你修改或发布程序（或任何基于程序的作品），你就表明你接受这一许可证以及它的所有有关复制，发布和修改程序或基<br /><br />于程序的作品的条款和条件。</font><br /><p><font size="2">6. <br />每当你重新发布程序（或任何基于程序的作品）时，接受者自动从原始许可证颁发者那里接到受这些条款和条件支配的复制，发布或修改程序的许可证。你不可以对接受者履行这里赋予他们的权利强加其他限制。你也没有强求第三方履行许可证条款的义务。</font><br /><p><font size="2">7. <br />如果由于法院判决或违反专利的指控或任何其他原因（不限于专利问题）的结果，强加于你的条件（不管是法院判决，<a name=1></a><B style=\'color:black;background-color:#A0FFFF\'>协议</B>或其他）和许可证的条件有冲突。他们也不能用许可证条款为你开脱。在你不能同时满足本许可证规定的义务及其他相关的义务时，作为结果，你可以根本不发布程序。例如，如果某一专利许可证不允许所有那些直接或间接从你那里接受副本的人们在不付专利费的情况下重新发布程序，唯一能同时满足两方面要求的办法是停止发布程序。<br /><br /> <br />如果本条款的任何部分在特定的环境下无效或无法实施，就使用条款的其余部分。并将条款作为整体用于其他环境。本条款的目的不在于引诱你侵犯专利或其他财产权的要求，或争论这种要求的有效性。本条款的主要目的在于保护自由软件发布系统的完整性。它是通过通用公共许可证的应用来实现的。许多人坚持应用这一系统，已经为通过这一系统发布大量自由软件作出慷慨的供献。作者／捐献者有权决定他／她是否通过任何其他系统发布软件。许可证持有人不能强制这种选择。</font><br /><p><font size="2">本节的目的在于明确说明许可证其余部分可能产生的结果。</font><br />{mospagebreak}<p><font size="2">8. <br />如果由于专利或者由于有版权的接口问题使程序在某些国家的发布和使用受到限止，将此程序置于许可证约束下的原始版权拥有者可以增加限止发布地区的条款，将这些国家明确排除在外。并在这些国家以外的地区发布程序。在这种情况下，许可证包含的限止条款和许可证正文一样有效。</font><br /><p><font size="2">9. <br />自由软件基金会可能随时出版通用公共许可证的修改版或新版。新版和当前的版本在原则上保持一致，但在提到新问题时或有关事项时，在细节上可能出现差别。<br /><br />每一版本都有不同的版本号。如果程序指定适用于它的许可证版本号以及“任何更新的版本”。你有权选择遵循指定的版本或自由软件基金会以后出版的新版本，如果程序未指定许可证版本，你可选择自由软件基金会已经出版的任何版本。</font><br /><p><font size="2">10. <br />如果你愿意将程序的一部分结合到其他自由程序中，而它们的发布条件不同。写信给作者，要求准予使用。如果是自由软件基金会加以版权保护的软件，写信给自由软件基金会。我们有时会作为例外的情况处理。我们的决定受两个主要目标的指导。这两个主要目标是：我们的自由软件的衍生作品继续保持自由状态。以及从整体上促进软件的共享和重复利用。</font><br /><p><font size="2"><br /><br />没有担保</font><br /><p><font size="2">11. <br />由于程序准予免费使用，在适用法准许的范围内，对程序没有担保。除非另有书面说明，版权所有者和／或其他提供程序的人们“一样”不提供任何类型的担保。不论是明确的，还是隐含的。包括但不限于隐含的适销和适合特定用途的保证。全部的风险，如程序的质量和性能问题都由你来承担。如果程序出现缺陷，你承担所有必要的服务，修复和改正的费用。</font><br /><p><font size="2">12. <br />除非适用法或书面<B style=\'color:black;background-color:#A0FFFF\'>协议</B>的要求，在任何情况下，任何版权所有者或任何按许可证条款修改和发布程序的人们都不对你的损失负有任何责任。包括由于使用或不能使用程序引起的任何一般的，特殊的，偶然发生的或重大的损失（包括但不限于数据的损失，或者数据变得不精确，或者你或第三方的持续的损失，或者程序不能和其他程序协调运行等）。即使版权所有者和其他人提到这种损失的可能性也不例外。</font><br /><p><font size="2"><br /><br />最后的条款和条件<br /><br />如何将这些条款用到你的新程序</font><br /><p><font size="2">如果你开发了新程序，而且你需要它得到公众最大限度的利用。要做到这一点的最好办法是将它变为自由软件。使得每个人都能在遵守条款的基础上对它进行修改和重新发布。<br /><br />为了做到这一点，给程序附上下列声明。最安全的方式是将它放在每个源程序的开头，以便最有效地传递拒绝担保的信息。每个文件至少应有“版权所有”行以及在什么地方能看到声明全文的说明。</font><br /><p><font size="2"><用一行空间给出程序的名称和它用来做什么的简单说明><br /><br />版权所有（C） 19XX <作者姓名><br /><br />这一程序是自由软件，你可以遵照自由软件基金会出版的GNU通用公共许可证条款来修改和重新发布这一程序。或者用许可证的第二版，或者（根据你的选择）用任何更新的版本。<br /><br />发布这一程序的目的是希望它有用，但没有任何担保。甚至没有适合特定目的的隐含的担保。更详细的情况请参阅GNU通用公共许可证。<br /><br />你应该已经和程序一起收到一份GNU通用公共许可证的副本。如果还没有，<br /><br />写信给：<br /><br />The Free Software Foundation, Inc., 675 Mass Ave, Cambridge,<br /><br />MA02139, USA<br /><br />还应加上如何和你保持联系的信息。</font><br /><p><font size="2">如果程序以交互方式进行工作，当它开始进入交互方式工作时，使它输出类似下面的简短声明：<br /><br />Gnomovision 第69版， 版权所有（C） 19XX， 作者姓名，<br /><br />Gnomovision绝对没有担保。 要知道详细情况，请输入‘show w’。<br /><br />这是自由软件，欢迎你遵守一定的条件重新发布它，要知道详细情况，<br /><br />请输入‘show c’。<br /><br />假设的命令‘show w’和‘show c’应显示通用公共许可证的相应条款。当然，你使用的命令名称可以不同于‘show <br />w’和‘show c’。根据你的程序的具体情况，也可以用菜单或鼠标选项来显示这些条款。</font><br /><p><font size="2">如果需要，你应该取得你的上司（如果你是程序员）或你的学校签署放弃程序版权的声明。下面只是一个例子，你应该改变相应的名称：<br /><br />Yoyodyne公司以此方式放弃James Harker<br /><br />所写的 Gnomovision程序的全部版权利益。<br /><br /><Ty coon签名>，1989.4.1<br /><br />Ty coon付总裁</font><br /><p><font size="2">这一许可证不允许你将程序并入专用程序。如果你的程序是一个子程序库。</font><br /><p><font size="2">你可能会认为用库的方式和专用应用程序连接更有用。如果这是你想做的事，使用GNU库通用公共许可证代替本许可证。</font></p>', '', 1, 0, 0, 0, '2004-08-19 20:11:07', 62, '', '2004-09-25 22:10:05', 62, 0, '0000-00-00 00:00:00', '2004-08-19 00:00:00', '0000-00-00 00:00:00', '', '', 'menu_image=-1\nitem_title=1\npageclass_sfx=\nback_button=\nrating=\nauthor=\ncreatedate=\nmodifydate=\npdf=\nprint=\nemail=', 1, 0, 11, '																				', '																				', 0, 16);

# --------------------------------------------------------

#
# Table structure for table `#__content_frontpage`
#

CREATE TABLE `#__content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__content_frontpage`
#

INSERT INTO `#__content_frontpage` VALUES (1, 1);
# --------------------------------------------------------



#
# Table structure for table `#__content_rating`
#

CREATE TABLE `#__content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) TYPE=MyISAM;

# --------------------------------------------------------

# Table structure for table `#__core_log_items`
#
# To be implemented in Version 4.6

CREATE TABLE `#__core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `#__core_log_searches`
#
# To be implemented in Version 4.6

CREATE TABLE `#__core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(11) unsigned NOT NULL default '0'
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `#__groups`
#

CREATE TABLE `#__groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__groups`
#

INSERT INTO `#__groups` VALUES (0, 'Public');
INSERT INTO `#__groups` VALUES (1, 'Registered');
INSERT INTO `#__groups` VALUES (2, 'Special');
# --------------------------------------------------------

#
# Table structure for table `#__mambots`
#

CREATE TABLE `#__mambots` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `element` varchar(100) NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) TYPE=MyISAM;

INSERT INTO #__mambots VALUES (1,'Mambo图片','mosimage','content',0,-10000,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (2,'Mambo分页','mospaging','content',0,10000,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (3,'原有Mambot置入','legacybots','content',0,1,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (4,'搜索引擎优化链接','mossef','content',0,3,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (5,'Mambo文章评级','mosvote','content',0,4,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (6,'搜索内容','content.searchbot','search',0,1,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (7,'搜索网站链接','weblinks.searchbot','search',0,2,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (8,'代码支持','moscode','content',0,2,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (9,'非所见即所得编辑器','none','editors',0,0,1,1,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (10,'TinyMCE所见即所得编辑器','tinymce','editors',0,0,0,0,0,0,'0000-00-00 00:00:00','theme=default');
INSERT INTO #__mambots VALUES (11,'Mambo图片编辑器按钮','mosimage.btn','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (12,'Mambo分页编辑器按钮','mospage.btn','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00','');
INSERT INTO #__mambots VALUES (13,'搜索联系人','contacts.searchbot','search',0,3,1,1,0,0,'0000-00-00 00:00:00','');

# --------------------------------------------------------

#
# Table structure for table `#__menu`
#

CREATE TABLE `#__menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(25) default NULL,
  `name` varchar(100) default NULL,
  `link` text,
  `type` varchar(50) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `componentid` int(11) unsigned NOT NULL default '0',
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `utaccess` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) TYPE=MyISAM;

#
# Dumping data for table `#__menu`
#

INSERT INTO `#__menu` VALUES (1, 'mainmenu', '首页', 'index.php?option=com_frontpage', 'components', 1, 0, 10, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'leading=1\r\nintro=2\r\nlink=1\r\nimage=1\r\npage_title=0\r\nheader=欢迎光临Mambo\r\norderby_sec=front\r\nprint=0\r\npdf=0\r\nemail=0');
INSERT INTO `#__menu` VALUES (2, 'mainmenu', '新闻', 'index.php?option=com_content&task=section&id=1', 'content_section', 1, 0, 1, 0, 3, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `#__menu` VALUES (3, 'mainmenu', '联系我们', 'index.php?option=com_contact', 'components', 1, 0, 7, 0, 7, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `#__menu` VALUES (4, 'mainmenu', '网站链接', 'index.php?option=com_weblinks', 'components', 1, 0, 4, 0, 6, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'image=web_links.jpg\r\nimage_align=right');
INSERT INTO `#__menu` VALUES (5, 'othermenu', 'Mambo中国', 'http://www.mambochina.net', 'url', 1, 0, 0, 0, 1, 0, '0000-00-00 00:00:00', 0, 1, 0, 3, '');
INSERT INTO `#__menu` VALUES (6, 'othermenu', 'Mambo主站', 'http://www.mamboserver.com', 'url', 1, 0, 0, 0, 2, 0, '0000-00-00 00:00:00', 0, 1, 0, 3, '');
INSERT INTO `#__menu` VALUES (7, 'othermenu', '后台管理', 'administrator/', 'url', 1, 0, 0, 0, 4, 0, '0000-00-00 00:00:00', 0, 1, 0, 3, 'menu_image=-1');
INSERT INTO `#__menu` VALUES (8, 'othermenu', 'Mambo开发中心', 'http://www.mamboforge.net', 'url', 1, 0, 0, 0, 3, 0, '0000-00-00 00:00:00', 0, 1, 0, 3, '');
INSERT INTO `#__menu` VALUES (21, 'usermenu', '个人资料', 'index.php?option=com_user&task=UserDetails', 'url', 1, 0, 0, 0, 1, 0, '2000-00-00 00:00:00', 0, 0, 1, 3, '');
INSERT INTO `#__menu` VALUES (22, 'usermenu', '提交新闻', 'index.php?option=com_content&task=new&sectionid=1&Itemid=0', 'url', 1, 0, 0, 0, 2, 0, '2000-00-00 00:00:00', 0, 0, 1, 2, '');
INSERT INTO `#__menu` VALUES (23, 'usermenu', '申请链接', 'index.php?option=com_weblinks&task=new', 'url', 1, 0, 0, 0, 4, 0, '2000-00-00 00:00:00', 0, 0, 1, 2, '');
INSERT INTO `#__menu` VALUES (24, 'usermenu', '放回条目', 'index.php?option=com_user&task=CheckIn', 'url', 1, 0, 0, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 1, 2, '');
INSERT INTO `#__menu` VALUES (11, 'topmenu', '首页', 'index.php', 'url', 1, 0, 0, 0, 7, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `#__menu` VALUES (27, 'mainmenu', '站内搜索', 'index.php?option=com_search', 'components', 1, 0, 16, 0, 7, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `#__menu` VALUES (28, 'topmenu', '联系我们', 'index.php?option=com_contact&Itemid=3', 'url', 1, 0, 0, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `#__menu` VALUES (29, 'topmenu', '新闻', 'index.php?option=com_content&task=section&id=1&Itemid=2', 'url', 1, 0, 0, 0, 6, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `#__menu` VALUES (30, 'topmenu', '网站链接', 'index.php?option=com_weblinks&Itemid=4', 'url', 1, 0, 0, 0, 4, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, '');
INSERT INTO `#__menu` VALUES (33, 'mainmenu', 'Mambo许可协议', 'index.php?option=com_content&task=view&id=11', 'content_typed', 1, 0, 11, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '');
INSERT INTO `#__menu` VALUES (34, 'usermenu', '退出登录', 'index.php?option=com_login', 'components', 1, 0, 15, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 1, 3, '');
INSERT INTO `#__menu` VALUES (37, 'mainmenu', '新闻导入', 'index.php?option=com_newsfeeds', 'components', 1, 0, 12, 0, 9, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'menu_image=-1\r\npageclass_sfx=\r\nback_button=\r\npage_title=1\r\nheader=');
INSERT INTO `#__menu` VALUES (38, 'mainmenu', '嵌入页面', 'index.php?option=com_wrapper', 'wrapper', 1, 0, 0, 0, 10, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'menu_image=-1\r\npageclass_sfx=\r\nback_button=\r\npage_title=1\r\nheader=\r\nscrolling=auto\r\nwidth=100%\r\nheight=600\r\nheight_auto=1\r\nurl=www.mamboserver.com');
INSERT INTO `#__menu` VALUES (39, 'mainmenu', 'Blog风格', 'index.php?option=com_content&task=blogsection&id=0', 'content_blog_section', 1, 0, 0, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'count=8\r\nintro=3\r\nimage=0\r\norderby=date asc\r\nheader=A blog of all section with no images\r\nempty=');
# --------------------------------------------------------

#
# Dumping data for table `#__messages`
#

CREATE TABLE `#__messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` int(10) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` int(11) NOT NULL default '0',
  `priority` int(1) unsigned NOT NULL default '0',
  `subject` varchar(230) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Dumping data for table `#__messages_cfg`
#

CREATE TABLE `#__messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE `idx_user_var_name` (`user_id`,`cfg_name`)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `#__modules`
#

CREATE TABLE `#__modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(10) default NULL,
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) TYPE=MyISAM;

#
# Dumping data for table `#__modules`
#

INSERT INTO `#__modules` VALUES (1, '在线调查', '', 1, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_poll', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (2, '用户菜单', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 1, 1, 'menutype=usermenu', 1, 0);
INSERT INTO `#__modules` VALUES (3, '主菜单', '', 1, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 1, 'menutype=mainmenu', 1, 0);
INSERT INTO `#__modules` VALUES (4, '用户登录', '', 3, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (5, '新闻联合', '', 4, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_rssfeed', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (6, '最新文章', '', 4, 'user1', 0, '0000-00-00 00:00:00', 1, 'mod_latestnews', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (7, '站点统计', '', 4, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_stats', 0, 0, 1, 'serverinfo=1\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=', 0, 0);
INSERT INTO `#__modules` VALUES (8, '在线情况', '', 1, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_whosonline', 0, 0, 1, 'online=1\nusers=1\nmoduleclass_sfx=', 0, 0);
INSERT INTO `#__modules` VALUES (9, '热门文章', '', 6, 'user2', 0, '0000-00-00 00:00:00', 1, 'mod_mostread', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (10, '模版选择器','',6,'left',0,'0000-00-00 00:00:00',0,'mod_templatechooser', 0, 0, 1, 'show_preview=1', 0, 0);
INSERT INTO `#__modules` VALUES (11, '文章存档', '', 7, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_archive', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (12, '文章单元', '', 8, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_sections', 0, 0, 1, '', 1, 0);
INSERT INTO `#__modules` VALUES (13, '新闻快讯', '', 1, 'top', 0, '0000-00-00 00:00:00', 1, 'mod_newsflash', 0, 0, 1, 'catid=3\r\nstyle=random\r\nitems=\r\nmoduleclass_sfx=', 0, 0);
INSERT INTO `#__modules` VALUES (14, '相关文章', '', 9, 'left', 0, '0000-00-00 00:00:00', 0, 'mod_related_items', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (15, '站内搜索', '', 1, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_search', 0, 0, 0, '', 0, 0);
INSERT INTO `#__modules` VALUES (16, '随机图片', '', 9, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_random_image', 0, 0, 1, '', 0, 0);
INSERT INTO `#__modules` VALUES (17, '顶部菜单', '', 1, 'user3', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=topmenu\nmenu_style=list_flat\nmenu_images=n\nmenu_images_align=left\nexpand_menu=n\nclass_sfx=-nav\nmoduleclass_sfx=\nindent_image1=0\nindent_image2=0\nindent_image3=0\nindent_image4=0\nindent_image5=0\nindent_image6=0', 1, 0);
INSERT INTO `#__modules` VALUES (18, '横幅广告', '', 1, 'banner', 0, '0000-00-00 00:00:00', 1, 'mod_banners', 0, 0, 0, 'banner_cids=\nmoduleclass_sfx=\n', 1, 0);
INSERT INTO `#__modules` VALUES (0,'组件','',2,'cpanel',0,'0000-00-00 00:00:00',1,'mod_components',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'热门文章','',3,'cpanel',0,'0000-00-00 00:00:00',1,'mod_popular',0,99,1,'',0, 1);
INSERT INTO `#__modules` VALUES (0,'最新文章','',4,'cpanel',0,'0000-00-00 00:00:00',1,'mod_latest',0,99,1,'',0, 1);
INSERT INTO `#__modules` VALUES (0,'统计信息','',5,'cpanel',0,'0000-00-00 00:00:00',1,'mod_stats',0,99,1,'',0, 1);
INSERT INTO `#__modules` VALUES (0,'未读短信','',1,'header',0,'0000-00-00 00:00:00',1,'mod_unread',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'在线用户','',2,'header',0,'0000-00-00 00:00:00',1,'mod_online',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'所有菜单','',1,'top',0,'0000-00-00 00:00:00',1,'mod_fullmenu',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'导航条','',1,'pathway',0,'0000-00-00 00:00:00',1,'mod_pathway',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'工具栏','',1,'toolbar',0,'0000-00-00 00:00:00',1,'mod_toolbar',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'站内短信','',1,'inset',0,'0000-00-00 00:00:00',1,'mod_mosmsg',0,99,1,'',1, 1);
INSERT INTO `#__modules` VALUES (0,'快捷图标','',1,'icon',0,'0000-00-00 00:00:00',1,'mod_quickicon',0,99,1,'',1,1);
INSERT INTO `#__modules` VALUES (0, 'Mamboforge','',1,'cpanel',0,'0000-00-00 00:00:00',0,'',0,99,1,'rssurl=http://mamboforge.net/export/rss_sfnews.php\nrssitems=5\nrssdesc=1\ncache=0\nmoduleclass_sfx=',0,1);
INSERT INTO `#__modules` VALUES (31, '其它菜单', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=othermenu\nmenu_style=vert_indent\ncache=0\nmenu_images=0\nmenu_images_align=0\nexpand_menu=0\nclass_sfx=\nmoduleclass_sfx=\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=', 0, 0);

# --------------------------------------------------------

#
# Table structure for table `#__modules_menu`
#

CREATE TABLE `#__modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) TYPE=MyISAM;

#
# Dumping data for table `#__modules_menu`
#

INSERT INTO `#__modules_menu` VALUES (1,1);
INSERT INTO `#__modules_menu` VALUES (2,0);
INSERT INTO `#__modules_menu` VALUES (3,0);
INSERT INTO `#__modules_menu` VALUES (4,1);
INSERT INTO `#__modules_menu` VALUES (5,1);
INSERT INTO `#__modules_menu` VALUES (6,1);
INSERT INTO `#__modules_menu` VALUES (6,2);
INSERT INTO `#__modules_menu` VALUES (6,4);
INSERT INTO `#__modules_menu` VALUES (6,27);
INSERT INTO `#__modules_menu` VALUES (6,36);
INSERT INTO `#__modules_menu` VALUES (8,1);
INSERT INTO `#__modules_menu` VALUES (9,1);
INSERT INTO `#__modules_menu` VALUES (9,2);
INSERT INTO `#__modules_menu` VALUES (9,4);
INSERT INTO `#__modules_menu` VALUES (9,27);
INSERT INTO `#__modules_menu` VALUES (9,36);
INSERT INTO `#__modules_menu` VALUES (10,1);
INSERT INTO `#__modules_menu` VALUES (13,0);
INSERT INTO `#__modules_menu` VALUES (15,0);
INSERT INTO `#__modules_menu` VALUES (17,0);
INSERT INTO `#__modules_menu` VALUES (18,0);
INSERT INTO `#__modules_menu` VALUES (31, 0);

# --------------------------------------------------------

#
# Table structure for table `#__newsfeeds`
#

CREATE TABLE `#__newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(11) unsigned NOT NULL default '1',
  `cache_time` int(11) unsigned NOT NULL default '3600',
  `checked_out` tinyint(3) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`)
) TYPE=MyISAM;

#
# Dumping data for table `#__newsfeeds`
#

INSERT INTO `#__newsfeeds` VALUES (66, 16, 'Mamboforge.net', 'http://mamboforge.net/export/rss_sfnews.php', '', 1, 5, 3600, 0, '0000-00-00 00:00:00', 16);
INSERT INTO `#__newsfeeds` VALUES (66, 17, 'Mamboportal', 'http://www.mamboportal.com/index2.php?option=com_rss&no_html=1', '', 1, 5, 3600, 0, '0000-00-00 00:00:00', 17);
INSERT INTO `#__newsfeeds` VALUES (66, 18, 'Mambohut', 'http://www.mambohut.com/index2.php?option=com_rss&no_html=1', '', 1, 5, 3600, 0, '0000-00-00 00:00:00', 18);

# --------------------------------------------------------

#
# Table structure for table `#__poll_data`
#

CREATE TABLE `#__poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(4) NOT NULL default '0',
  `text` text NOT NULL default '',
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) TYPE=MyISAM;

#
# Dumping data for table `#__poll_data`
#

# --------------------------------------------------------

#
# Table structure for table `#__poll_date`
#

CREATE TABLE `#__poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__poll_date`
#

# --------------------------------------------------------

#
# Table structure for table `#__polls`
#

CREATE TABLE `#__polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Table structure for table `#__poll_menu`
#

CREATE TABLE `#__poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) TYPE=MyISAM;

#
# Dumping data for table `#__poll_menu`
#

# --------------------------------------------------------

#
# Table structure for table `#__sections`
#

CREATE TABLE `#__sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `image` varchar(100) NOT NULL default '',
  `scope` varchar(50) NOT NULL default '',
  `image_position` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_scope` (`scope`)
) TYPE=MyISAM;

#
# Dumping data for table `#__sections`
#

INSERT INTO `#__sections` VALUES (1, '新闻', '新闻', 'articles.jpg', 'content', 'right', '从下面列表选择一个分类，然后选择一篇文章阅读。', 1, 0, '0000-00-00 00:00:00', 1, 0, 1, '');
INSERT INTO `#__sections` VALUES (2, '新闻快讯','新闻快讯','','content','left','本类内容发布以后显示在顶部位置',1,0,'0000-00-00 00:00:00',2,0,1, '');

#
# Table structure for table `#__session`
#

CREATE TABLE `#__session` (
  `username` varchar(50) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(50) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`)
) TYPE=MyISAM;

#
# Table structure for table `#__stats_agents`
#

CREATE TABLE `#__stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) TYPE=MyISAM;

#
# Dumping data for table `#__stats_agents`
#

# --------------------------------------------------------

#
# Table structure for table `#__templates_menu`
#

CREATE TABLE `#__templates_menu` (
  `template` varchar(50) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`template`,`menuid`)
) TYPE=MyISAM;

# Dumping data for table `#__templates_menu`

INSERT INTO `#__templates_menu` VALUES ('rhuk_solarflare', '0', '0');
INSERT INTO `#__templates_menu` VALUES ('mambo_admin_blue', '0', '1');

# --------------------------------------------------------

#
# Table structure for table `#__template_positions`
#

CREATE TABLE `#__template_positions` (
  `id` int(11) NOT NULL auto_increment,
  `position` varchar(10) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__template_positions`
#

INSERT INTO `#__template_positions` VALUES (0, 'left', '');
INSERT INTO `#__template_positions` VALUES (0, 'right', '');
INSERT INTO `#__template_positions` VALUES (0, 'top', '');
INSERT INTO `#__template_positions` VALUES (0, 'bottom', '');
INSERT INTO `#__template_positions` VALUES (0, 'inset', '');
INSERT INTO `#__template_positions` VALUES (0, 'banner', '');
INSERT INTO `#__template_positions` VALUES (0, 'header', '');
INSERT INTO `#__template_positions` VALUES (0, 'footer', '');
INSERT INTO `#__template_positions` VALUES (0, 'newsflash', '');
INSERT INTO `#__template_positions` VALUES (0, 'legals', '');
INSERT INTO `#__template_positions` VALUES (0, 'pathway', '');
INSERT INTO `#__template_positions` VALUES (0, 'toolbar', '');
INSERT INTO `#__template_positions` VALUES (0, 'cpanel', '');
INSERT INTO `#__template_positions` VALUES (0, 'user1', '');
INSERT INTO `#__template_positions` VALUES (0, 'user2', '');
INSERT INTO `#__template_positions` VALUES (0, 'user3', '');
INSERT INTO `#__template_positions` VALUES (0, 'user4', '');
INSERT INTO `#__template_positions` VALUES (0, 'user5', '');
INSERT INTO `#__template_positions` VALUES (0, 'user6', '');
INSERT INTO `#__template_positions` VALUES (0, 'user7', '');
INSERT INTO `#__template_positions` VALUES (0, 'user8', '');
INSERT INTO `#__template_positions` VALUES (0, 'user9', '');
INSERT INTO `#__template_positions` VALUES (0, 'advert1', '');
INSERT INTO `#__template_positions` VALUES (0, 'advert2', '');
INSERT INTO `#__template_positions` VALUES (0, 'advert3', '');
INSERT INTO `#__template_positions` VALUES (0, 'icon', '');
INSERT INTO `#__template_positions` VALUES (0, 'debug', '');
# --------------------------------------------------------

#
# Table structure for table `#__users`
#

CREATE TABLE `#__users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `username` varchar(25) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`)
) TYPE=MyISAM;

#
# Table structure for table `#__usertypes`
#

CREATE TABLE `#__usertypes` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `mask` varchar(11) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

#
# Dumping data for table `#__usertypes`
#

INSERT INTO `#__usertypes` VALUES (0, 'superadministrator', '');
INSERT INTO `#__usertypes` VALUES (1, 'administrator', '');
INSERT INTO `#__usertypes` VALUES (2, 'editor', '');
INSERT INTO `#__usertypes` VALUES (3, 'user', '');
INSERT INTO `#__usertypes` VALUES (4, 'author', '');
INSERT INTO `#__usertypes` VALUES (5, 'publisher', '');
INSERT INTO `#__usertypes` VALUES (6, 'manager', '');
# --------------------------------------------------------

#
# Table structure for table `#__weblinks`
#

CREATE TABLE `#__weblinks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) TYPE=MyISAM;

#
# Dumping data for table `#__weblinks`
#

INSERT INTO `#__weblinks` VALUES (1, 2, 0, 'Mambo中国', 'http://www.mambochina.net', '开放、共享、互助的中文Mambo社区', '2004-10-05 10:18:31', 0, 1, 0, '0000-00-00 00:00:00', 1, 0, 1, '');

#
# Table structure for table `#__core_acl_aro`
#

CREATE TABLE `#__core_acl_aro` (
  `aro_id` int(11) NOT NULL auto_increment,
  `section_value` varchar(240) NOT NULL default '0',
  `value` varchar(240) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`aro_id`),
  UNIQUE KEY `section_value_value_aro` (`section_value`,`value`),
  UNIQUE KEY `#__gacl_section_value_value_aro` (`section_value`,`value`),
  KEY `hidden_aro` (`hidden`),
  KEY `#__gacl_hidden_aro` (`hidden`)
) TYPE=MyISAM;

#
# Table structure for table `#__core_acl_aro_groups`
#
CREATE TABLE `#__core_acl_aro_groups` (
  `group_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  PRIMARY KEY  (`group_id`),
  KEY `parent_id_aro_groups` (`parent_id`),
  KEY `#__gacl_parent_id_aro_groups` (`parent_id`),
  KEY `#__gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) TYPE=MyISAM;

#
# Dumping data for table `#__core_acl_aro_groups`
#
INSERT INTO `#__core_acl_aro_groups` VALUES (17,0,'ROOT',1,22);
INSERT INTO `#__core_acl_aro_groups` VALUES (28,17,'USERS',2,21);
INSERT INTO `#__core_acl_aro_groups` VALUES (29,28,'Public Frontend',3,12);
INSERT INTO `#__core_acl_aro_groups` VALUES (18,29,'Registered',4,11);
INSERT INTO `#__core_acl_aro_groups` VALUES (19,18,'Author',5,10);
INSERT INTO `#__core_acl_aro_groups` VALUES (20,19,'Editor',6,9);
INSERT INTO `#__core_acl_aro_groups` VALUES (21,20,'Publisher',7,8);
INSERT INTO `#__core_acl_aro_groups` VALUES (30,28,'Public Backend',13,20);
INSERT INTO `#__core_acl_aro_groups` VALUES (23,30,'Manager',14,19);
INSERT INTO `#__core_acl_aro_groups` VALUES (24,23,'Administrator',15,18);
INSERT INTO `#__core_acl_aro_groups` VALUES (25,24,'Super Administrator',16,17);

#
# Table structure for table `#__core_acl_groups_aro_map`
#
CREATE TABLE `#__core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL default '0',
  `section_value` varchar(240) NOT NULL default '',
  `aro_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) TYPE=MyISAM;

#
# Table structure for table `#__core_acl_aro_sections`
#
CREATE TABLE `#__core_acl_aro_sections` (
  `section_id` int(11) NOT NULL auto_increment,
  `value` varchar(230) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(230) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`section_id`),
  UNIQUE KEY `value_aro_sections` (`value`),
  UNIQUE KEY `#__gacl_value_aro_sections` (`value`),
  KEY `hidden_aro_sections` (`hidden`),
  KEY `#__gacl_hidden_aro_sections` (`hidden`)
) TYPE=MyISAM;

INSERT INTO `#__core_acl_aro_sections` VALUES (10,'users',1,'Users',0);



# Dumping data for table `#__users`


# TEST

# INSERT INTO `#__users` VALUES (62, 'Administrator', 'admin', 'admin@wherever', '21232f297a57a5a743894a0e4a801fc3', 'superadministrator', 0, 1, 25, '2004-06-06 00:00:00', '0000-00-00 00:00:00', '', '');

# INSERT INTO `#__core_acl_aro` VALUES (62,'users','62',0,'Administrator',0);

# INSERT INTO `#__core_acl_groups_aro_map` VALUES (25,'',62);

# INSERT INTO `#__users` VALUES (63, 'Editor', 'editor', 'editor@wherever', '5aee9dbd2a188839105073571bee1b1f', 'editor', 0, 0, 20, '2004-06-06 00:00:00', '0000-00-00 00:00:00', '', '');

# INSERT INTO `#__core_acl_aro` VALUES (63,'users','63',0,'Editor',0);

# INSERT INTO `#__core_acl_groups_aro_map` VALUES (20,'',63);

#
