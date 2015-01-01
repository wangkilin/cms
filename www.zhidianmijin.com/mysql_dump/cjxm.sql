-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost:3308
-- 生成日期: 2009 年 07 月 28 日 09:16
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ming`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `cjxm`
-- 

CREATE TABLE `cjxm` (
  `id` int(11) NOT NULL auto_increment,
  `xmmc` varchar(50) default NULL,
  `cjurl` longtext,
  `cjbody` varchar(255) default NULL,
  `xm1` varchar(50) default NULL,
  `cjxm1` longtext,
  `xm2` varchar(50) default NULL,
  `cjxm2` longtext,
  `xm3` varchar(50) default NULL,
  `cjxm3` longtext,
  `xm4` varchar(50) default NULL,
  `cjxm4` longtext,
  `xm5` varchar(50) default NULL,
  `cjxm5` longtext,
  `xm6` varchar(50) default NULL,
  `cjxm6` longtext,
  `xm7` varchar(50) default NULL,
  `cjxm7` longtext,
  `xm8` varchar(50) default NULL,
  `cjxm8` longtext,
  `xm9` varchar(50) default NULL,
  `cjxm9` longtext,
  `xm10` varchar(50) default NULL,
  `cjxm10` longtext,
  `xm11` varchar(50) default NULL,
  `cjxm11` longtext,
  `xm12` varchar(50) default NULL,
  `cjxm12` longtext,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- 
-- 导出表中的数据 `cjxm`
-- 

INSERT INTO `cjxm` VALUES (1, '黄道查询', 'http://astro.sina.com.cn/jian/hdrl/[id].shtml', '当日统览|<input type=', '农历', '农历|</p>', '岁次', '岁次</strong></td>										<td>|</tr>', '每日胎神占方', '每日胎神占方</strong></td>										<td>|</tr>', '五行', '五行</strong></td>										<td>|<td height="30"><img src="http://www.sinaimg.cn/ast/2007index/star_lmy_029.gif" widt', '冲', 'lmy_029.gif" width="26" height="23" alt=""/></td>										<td>|</tr>', '彭祖百忌', '彭祖百忌</strong></td>										<td>|</tr>', '吉神宜趋', '吉神宜趋</strong></td>										<td>|</tr>', '宜', 'ex/star_lmy_030.gif" width="26" height="23" alt=""/></td>										<td>|</tr>', '凶神宜忌', '凶神宜忌</strong></td>										<td>|</tr>', '忌', '007index/star_lmy_031.gif" width="26" height="23" alt=""/></td>										<td>|</tr>', '', '', '', '');
INSERT INTO `cjxm` VALUES (2, '星座每日运势', 'http://astro.sina.com.cn/pc/west/frame0_[id].html', '<!-- SUDA_CODE_END -->|<!-- 星座运势内容end -->', '星座', '<span>|<em>', '综合运势', '<h4>综合运势</h4><p>|</p>', '爱情运势', '爱情运势</h4><p>|</p>', '工作状况', '工作状况</h4><p>|</p>', '理财投资', '理财投资</h4><p>|</p>', '健康指数', '健康指数</h4><p>|</p>', '商谈指数', '商谈指数</h4><p>|</p>', '幸运颜色', '幸运颜色</h4><p>|</p>', '幸运数字', '幸运数字</h4><p>|</p>', '速配星座', '速配星座</h4><p>|</p>', '综合评估', '<div class="lotconts">|</div>', '有效期限', '有效日期:|</li>');
INSERT INTO `cjxm` VALUES (3, '星座明日运势', 'http://astro.sina.com.cn/pc/west/frame0_[id]_1.html', '<!-- SUDA_CODE_END -->|<!-- 星座运势内容end -->', '星座', '<span>|<em>', '综合运势', '<h4>综合运势</h4><p>|</p>', '爱情运势', '爱情运势</h4><p>|</p>', '工作状况', '工作状况</h4><p>|</p>', '理财投资', '理财投资</h4><p>|</p>', '健康指数', '健康指数</h4><p>|</p>', '商谈指数', '商谈指数</h4><p>|</p>', '幸运颜色', '幸运颜色</h4><p>|</p>', '幸运数字', '幸运数字</h4><p>|</p>', '速配星座', '速配星座</h4><p>|</p>', '综合评估', '<div class="lotconts">|</div>', '有效期限', '有效日期:|</li>');
INSERT INTO `cjxm` VALUES (4, '星座每周运势', 'http://astro.sina.com.cn/pc/west/frame1_[id].html', '<!-- SUDA_CODE_END -->|<!-- 星座运势内容end -->', '星座', '<span>|<em>', '有效期', '有效日期:|</li>', '标题', '<li class="notes">|</li>', '整体运势', '整体运势|</p>', '爱情运势 有对象', '有对象:|</p>', '爱情运势 没对象', '没对象:|</p>', '健康运势', '健康运势|</p>', '工作学业运', '工作学业运|</p>', '性欲指数', '性欲指数|</p>', '红心日', '红心日</h4>|</p>', '黑梅日', '黑梅日</h4>|</p>', '黑梅日', '黑梅日</h4>|</p>');
INSERT INTO `cjxm` VALUES (5, '星座每月运势', 'http://astro.sina.com.cn/pc/west/frame2_[id].html', '<!-- SUDA_CODE_END -->|<!-- 星座运势内容end -->', '星座', '<span>|<em>', '有效期限', '有效日期:|</li>', '整体运势', '整体运势|</p>', '爱情运势', '爱情运势|</p>', '投资理财运', '投资理财运|</p>', '解压方式', '解压方式</h4>|</p>', '幸运物', '幸运物</h4>|</p>', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (6, '星座每年运势', 'http://astro.sina.com.cn/pc/west/frame3_[id].html', '<!-- SUDA_CODE_END -->|<!-- 星座运势内容end -->', '星座', '<span>|<em>', '标题', '<li class="notes">|</li>', '整体概况', '整体概况|</p>', '功课学业', '功课学业|</p>', '工作职场', '工作职场|</p>', '金钱理财', '金钱理财|</p>', '恋爱婚姻', '恋爱婚姻|</p>', '有效期限', '有效日期:|</li>', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (7, '星座年度爱情运势', 'http://astro.sina.com.cn/pc/west/frame4_[id].html', '<!-- SUDA_CODE_END -->|<!-- 星座运势内容end -->', '星座', '<span>|<em>', '有效日期', '有效日期:|</li>', '总论', '<div class="lotconts">|</div>', '女生篇', '<div class="m_left">|</div>', '男生篇', '<div class="m_right">|</div>', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (8, '星座资料采集', 'http://astro.sina.com.cn/jian/[id].shtml', '<!----运程查询页面顶部广告位-结束---->|<!-- Start  Wrating  -->', '标题', '<font class=f1491>|</font>', '内容', '<td width=90% class=l151><br><br>|</td><td width=5%></td></tr>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (9, '姓名', 'http://astro.lady.qq.com/a/20070208/000014_[id].htm', '你们的姓名笔画总数表示|</tr>', '目标', '：|</td>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (11, '日干一', 'http://life.httpcn.com/sm/vip_bz_ok.asp?youname=刘云局&sex=男&nian=2007&yue=01&ri=02&hh=15&fen=0&nian1=2007&yue1=01&bz1=1&bz2=1&bz3=[id]&bz4=1', '生肖个性|根据四柱预测学部', '日干心性', '<td width="15%">日干心性</td><td>|</td></tr>', '日干支层次', '日干支层次</td><td>|</td></tr>', '日干支分析', '日干支分析</td>|<br />', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (12, '日干二', 'http://life.httpcn.com/sm/vip_bz_rg_ok.asp?youname=文华明&sex=男&nx=&ztyisno=ON&nian=2007&yue=12&ri=20&hh=23&fen=0&shi=子时&bz1=1&bz2=2&bz3=[id]&bz4=3', '生肖个性|想深入详细了', '性格分析', '格分析</td>|<span class="sy">', '爱情分析', '爱情分析</td><td>|<span class="sy">', '事业分析', '事业分析</td><td>|<span class="sy">', '财运分析', '财运分析</td><td>|<span class="sy">', '健康分析', '健康分析</td><td>|<span class="sy">', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (13, '三命通会', 'http://life.httpcn.com/sm/vip_bz_ok.asp?youname=刘云局&sex=男&nian=2007&yue=01&ri=02&hh=15&fen=0&nian1=2007&yue1=01&bz1=1&bz2=1&bz3=[id1]&bz4=[id2]', '生肖个性|月日时命理', '三命通会', '三命通会</td><td>|<br />', '三命通会二', '<font color="000055">|</font>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (14, '三才数理', 'http://life.httpcn.com/Sm/vip_name.asp?xing=方&ming=[id]&sex=男', '对三才数理的影响|总评及建议', '三才配置', '您的姓名三才配置为：|。', '意义', '<tr class="tdbgcolor"><td valign="middle" colspan="2">|）', '详细解释', '详细解释：<br />|<span class="sy">', '对基础运的影响', '对基础运的影响</td><td>|）', '对成功运的影响', '对成功运的影响</td><td>|）', '对人际关系的影响', '对人际关系的影响</td><td>|）', '对性格的影响', '对性格的影响</td><td>|<span class="sy">', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (15, '穷通宝鉴调候用神参考', 'http://life.httpcn.com/sm/vip_bz_ok.asp?youname=在要&sex=男&nx=&ztyisno=ON&nian=2007&yue=7&ri=21&hh=8&fen=11&shi=辰时&nian1=2007&yue1=8&ri1=21&hh1=8&fen1=11&belong=猪&bz1=丁亥&bz2=壬子&bz3=己丑&bz4=戊辰', '四季用神参考|生肖个性', '参考', '月，|<span class="sy">', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (16, '观音灵签', 'http://life.httpcn.com/sm/vip_qian_gy.asp?n0=4&n1=59&qianci=8&y=2007&m=12&d=21&hh=8&fen=11&name=在要&b=男&x=&ztyisno=ON&pid=&cid=&unionsiteitem=2&unionsiteid=&unionsitepwd=&gourl=vip_qian_gy.asp#z', '观音解签|点击这里返回抽签', '解签', '：<br />|</td></tr>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (17, '姓氏起源', 'http://www.yaogens.com/www/15/2007-06/72.html', '<!--header----main-->|相关主题', '姓氏', 'h1>姓氏起源——|</h1>', '起源', 'http://pagead2.googlesyndication.com/pagead/show_ads.js">|<div style="text-align:center; padding:3px;">', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `cjxm` VALUES (18, '生男生女', 'http://www.er51.com/huaiyun/snsnbiao.htm', '<P align=center>12</P></TD>|</TABLE>', '生男生女', '</TR>|</TBODY>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
