<?php
/**
* @version $Id: admin_english.php,v 1.30 2004/10/13 09:07:52 dappa Exp $
* @package adminLanguage 1.0
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* Mambo中国 http://www.mambochina.net
*/

/*
 admin_simplified_chinese.php for Mambo4.5.1a pro
 Mambo4.5.1a pro 后台简体中文包
 Mambo中国 http：//www.mambochina.net
 2004-10-16
*/

defined( '_VALID_MOS' ) or die( '禁止直接访问本文件！' );

DEFINE('_A_CANCEL','取消'); // needed for $alt text in toolbar item
DEFINE('_A_SAVE','保存'); // needed for $alt text in toolbar item

/**
* @location /../includes/mambo.php
* @desc Includes translations of several droplists and non-translated stuff
*/

//Droplist
DEFINE('_A_TOP','顶级');
DEFINE('_A_ALL','全部');
DEFINE('_A_NONE','无');
DEFINE('_A_SELECT_IMAGE','选择图片');
DEFINE('_A_NO_USER','没有用户');
DEFINE('_A_CREATE_CAT','必须先创建一个分类');
DEFINE('_A_PARENT_BROWSER_NAV','父窗口，带浏览器导航');
DEFINE('_A_NEW_BROWSER_NAV','新窗口，带浏览器导航');
DEFINE('_A_NEW_W_BROWSER_NAV','新窗口，不带浏览器导航');

//Main Texts
DEFINE('_A_PUBLISHED_PEND','已发布，但在<u>审理中</u>');
DEFINE('_A_PUBLISHED_CURRENT','已发布，<u>当前在用</u>');
DEFINE('_A_PUBLISHED_EXPIRED','已发布，但已<u>过期</u>');
DEFINE('_A_PUBLISHED_NOT','未发布');
DEFINE('_A_TOGGLE_STATE','单击图标来切换状态。');

//Alt Hover
DEFINE('_A_PENDING','审理中');
DEFINE('_A_VISIBLE','可视的');
DEFINE('_A_FINISHED','已结束');

/**
* @desc Includes the main adminLanguage class which refers to var's for translations
*/
class adminLanguage {

//templates/mambo_admin_blue/login.php
var $A_USERNAME = '用户名';
var $A_PASSWORD = '密码';
var $A_WELCOME_MAMBO = '<p>欢迎使用Mambo！</p><p>请使用有效的用户名和密码来登录管理后台</p>';
var $A_WARNING_JAVASCRIPT = '！警告！ Javascript 功能必须打开，才能进行正常的管理操作。';

//templates/mambo_admin_blue/index.php
var $A_GENERATE_TIME = '页面生成时间：%f 秒';
var $A_LOGOUT = '退出';

//popups/contentwindow.php
var $A_TITLE_CPRE = '内容预览';
var $A_CLOSE = '关闭';
var $A_PRINT = '打印';

//popups/modulewindow.php
var $A_TITLE_MPRE = '模块预览';

//popups/pollwindow.php
var $A_TITLE_PPRE = '在线调查预览';
var $A_VOTE = '投票';
var $A_RESULTS = '结果';

//popups/uploadimage.php
var $A_TITLE_UPLOAD = '上传文件';
var $A_FILE_UPLOAD = '文件上传';
var $A_UPLOAD = '上传';

//modules/mod_components.php
var $A_ERROR = '错误！';

//modules/mod_fullmenu.php
var $A_MENU_HOME = '首页';
var $A_MENU_HOME_PAGE = '管理后台首页';
var $A_MENU_SITE = '网站';
var $A_MENU_CONFIGURATION = '配置';
var $A_MENU_LANGUAGES = '语言';
var $A_MENU_MANAGE_LANG = '管理语言';
var $A_MENU_LANG_MANAGE = '语言管理';
var $A_MENU_INSTALL = '安装';
var $A_MENU_INSTALL_LANG = '安装语言';
var $A_MENU_MEDIA_MANAGE = '媒体管理';
var $A_MENU_MANAGE_MEDIA = '管理媒体文件';
var $A_MENU_PREVIEW = '预览';
var $A_MENU_NEW_WINDOW = '在新窗口打开';
var $A_MENU_INLINE = '嵌入窗口';
var $A_MENU_INLINE_POS = '嵌入窗口（位置）';
var $A_MENU_STATISTICS = '统计';
var $A_MENU_STATISTICS_SITE = '网站统计';
var $A_MENU_BROWSER = '浏览器、操作系统、域';
var $A_MENU_PAGE_IMP = '页面浏览';
var $A_MENU_SEARCH_TEXT = '搜索文本';
var $A_MENU_TEMP_MANAGE = '模版管理';
var $A_MENU_TEMP_CHANGE = '更换网站模版';
var $A_MENU_SITE_TEMP = '网站模版';
var $A_MENU_ADMIN_TEMP = '管理后台模版';
var $A_MENU_ADMIN_CHANGE_TEMP = '更换管理后台模版';
var $A_MENU_MODUL_POS = '模块位置';
var $A_MENU_TEMP_POS = '模版位置';
var $A_MENU_TRASH_MANAGE = '回收站管理';
var $A_MENU_MANAGE_TRASH = '管理回收站';
var $A_MENU_USER_MANAGE = '用户管理';
var $A_MENU_MANAGE_USER = '管理用户';
var $A_MENU_ADD_EDIT = '新增/编辑用户';
var $A_MENU_MASS_MAIL = '群发邮件';
var $A_MENU_MAIL_USERS = '发送邮件给一个用户或一组用户';
var $A_MENU_MANAGE_STR = '管理网站结构';
var $A_MENU_CONTENT = '内容';
var $A_MENU_CONTENT_MANAGE = '内容管理';
var $A_MENU_CONTENT_MANAGERS = '内容管理';
var $A_MENU_MANAGE_CONTENT = '管理内容条目';
var $A_MENU_ITEMS = '条目';
var $A_MENU_ADDNEDIT = '新增/编辑';
var $A_MENU_ARCHIVE = '存档';
var $A_MENU_OTHER_MANAGE = '其它管理';
var $A_MENU_ITEMS_FRONT = '管理首页条目';
var $A_MENU_ITEMS_CONTENT = '管理静态内容条目';
var $A_MENU_ITEMS_ARCHIVE = '管理存档条目';
var $A_MENU_ARCHIVE_MANAGE = '存档管理';
var $A_MENU_CONTENT_SEC = '管理内容单元';
var $A_MENU_CONTENT_CAT = '管理内容分类';
var $A_MENU_COMPONENTS = '组件';
var $A_MENU_INST_UNST = '安装/卸载';
var $A_MENU_MORE_COMP = '更多组件';
var $A_MENU_MODULES = '模块';
var $A_MENU_INSTALL_CUST = '安装/卸载模块';
var $A_MENU_SITE_MOD = '网站模块';
var $A_MENU_SITE_MOD_MANAGE = '管理网站模块';
var $A_MENU_ADMIN_MOD = '后台模块';
var $A_MENU_ADMIN_MOD_MANAGE = '管理后台模块';
var $A_MENU_MAMBOTS = 'Mambots';
var $A_MENU_CUSTOM_MAMBOT = '安装/卸载mambot';
var $A_MENU_SITE_MAMBOTS = '网站Mambots';
var $A_MENU_MAMBOT_MANAGE = '管理网站Mambots';
var $A_MENU_MESSAGES = '短信';
var $A_MENU_INBOX = '收件箱';
var $A_MENU_PRIV_MSG = '站内短信';
var $A_MENU_GLOBAL_CHECK = '全部放回';
var $A_MENU_CHECK_INOUT = '放回所有取出的条目';
var $A_MENU_SYSTEM_INFO = '系统信息';
var $A_MENU_CLEAN_CACHE = '清空缓存';
var $A_MENU_CLEAN_CACHE_ITEMS = '清空内容条目缓存';
var $A_MENU_BIG_THANKS = '衷心感谢参与者';
var $A_MENU_SUPPORT = '支持';
var $A_MENU_SYSTEM = '系统';

//modules/mod_latest.php
var $A_LATEST_ADDED = '最近新增的内容';

//modules/mod_online.php
var $A_ONLINE_USERS = '在线用户';

//modules/mod_popular.php
var $A_POPULAR_MOST = '热门条目';
var $A_CREATED = '创建';
var $A_HITS = '点击';

//modules/mod_quickicon.php
var $A_MENU_MANAGER = '菜单管理';
var $A_FRONTPAGE_MANAGER = '首页管理';
var $A_STATIC_MANAGER = '静态内容管理';
var $A_SECTION_MANAGER = '单元管理';
var $A_CATEGORY_MANAGER = '分类管理';
var $A_ALL_MANAGER = '所有内容条目';
var $A_TRASH_MANAGER = '回收站管理';
var $A_GLOBAL_CONF = '全局配置';
var $A_HELP = '帮助';

//includes/menubar.html.php
var $A_NEW = '新增';
var $A_PUBLISH = '发布';
var $A_DEFAULT = '默认';
var $A_ASSIGN = '分配';
var $A_UNPUBLISH = '取消发布';
var $A_UNARCHIVE = '取消存档';
var $A_EDIT = '编辑';
var $A_DELETE = '删除';
var $A_TRASH = '回收站';
var $A_SAVE = '保存';
var $A_BACK = '后退';
var $A_CANCEL = '取消';

//Alerts
var $A_ALERT_SELECT_TO = '请从列表中选择条目来';
var $A_ALERT_SELECT_PUB = '请从列表中选择条目来发布';
var $A_ALERT_SELECT_PUB_LIST = '请从列表中选择条目来设为默认';
var $A_ALERT_ITEM_ASSIGN = '请选择条目来分配';
var $A_ALERT_SELECT_UNPUBLISH = '请从列表中选择条目来取消发布';
var $A_ALERT_SELECT_ARCHIVE = '请从列表中选择条目来存档';
var $A_ALERT_SELECT_UNARCHIVE = '请从列表中选择条目来取消存档';
var $A_ALERT_SELECT_EDIT = '请从列表中选择条目来编辑';
var $A_ALERT_SELECT_DELETE = '请从列表中选择条目来删除';
var $A_ALERT_CONFIRM_DELETE = '确认删除选中的条目？';

//Alerts
var $A_ALERT_ENTER_PASSWORD = '请输入密码'; 
var $A_ALERT_INCORRECT = '无效的用户名、密码或访问级别，请重试';
var $A_ALERT_INCORRECT_TRY = '无效的用户名或密码，请重试';
var $A_ALERT_ALPHA = '文件名只能包含字母或数字，不能有空格。';
var $A_ALERT_IMAGE_UPLOAD = '请选择图片来上传';
var $A_ALERT_IMAGE_EXISTS = '图片 $userfile_name 已经存在。';
var $A_ALERT_IMAGE_FILENAME = '文件类型必须是 gif, png, jpg, bmp, swf, doc, xls 或 ppt';
var $A_ALERT_UPLOAD_FAILED = '上传 $userfile_name 失败';
var $A_ALERT_UPLOAD_SUC = '上传 $userfile_name 到 $media_path 成功';
var $A_ALERT_UPLOAD_SUC2 = '上传 $userfile_name 到 $base_Dir 成功';

//includes/pageNavigation.php
var $A_OF = '/'; 
var $A_NO_RECORD_FOUND = '没有找到记录';
var $A_FIRST_PAGE = '第一页';
var $A_PREVIOUS_PAGE = '上一页';
var $A_NEXT_PAGE = '下一页';
var $A_END_PAGE = '最后一页';
var $A_PREVIOUS = '上一页';
var $A_NEXT = '下一页';
var $A_END = '最后一页';
var $A_DISPLAY = '显示';
var $A_MOVE_UP = '上移';
var $A_MOVE_DOWN = '下移';

//DIRECTORY COMPONENTS ALL FILES
var $A_COMP_CHECKED_OUT = '取出';
var $A_COMP_TITLE = '标题';
var $A_COMP_IMAGE = '图片';
var $A_COMP_FRONT_PAGE = '首页';
var $A_COMP_IMAGE_POSITION = '图片位置';
var $A_COMP_FILTER = '筛选';
var $A_COMP_ORDERING = '显示次序';
var $A_COMP_ACCESS_LEVEL = '访问级别';
var $A_COMP_PUBLISHED = '发布';
var $A_COMP_UNPUBLISHED = '未发布';
var $A_COMP_REORDER = '重新排序';
var $A_COMP_ACCESS = '访问';
var $A_COMP_SECTION = '单元';
var $A_COMP_NB = '编号';
var $A_COMP_ACTIVE = '活动条目';
var $A_COMP_TRASH = '回收站条目';
var $A_COMP_DESCRIPTION = '描述';
var $A_COMP_SELECT_MENU_TYPE = '请选择菜单类型';
var $A_COMP_ENTER_MENU_NAME = '请输入菜单项名称';
var $A_COMP_CREATE_MENU_LINK = '确认创建链接到菜单？ \n任何对未保存的更改将丢失。';
var $A_COMP_LINK_TO_MENU = '链接到菜单';
var $A_COMP_CREATE_MENU = '将在你选择的菜单上创建新的菜单项';
var $A_COMP_SELECT_MENU = '选择菜单';
var $A_COMP_MENU_TYPE_SELECT = '选择菜单类型';
var $A_COMP_MENU_NAME_ITEM = '菜单项名称';
var $A_COMP_MENU_LINKS = '现有的菜单链接';
var $A_COMP_NONE = '无';
var $A_COMP_MENU = '菜单';
var $A_COMP_TYPE = '类型';
var $A_COMP_EDIT = '编辑';
var $A_COMP_ADD = '新增';
var $A_COMP_ITEM_NAME = '条目名称';
var $A_COMP_STATE = '状态';
var $A_COMP_TRASHED = '已回收';
var $A_COMP_NAME = '名称';
var $A_COMP_DEFAULT = '默认';
var $A_COMP_CATEG = '分类';
var $A_COMP_LINK_USER = '关联用户';
var $A_COMP_CONTACT = '联系人';
var $A_COMP_EMAIL = 'E-mail';
var $A_COMP_PREVIEW = '预览';
var $A_COMP_ITEMS = '条目';
var $A_COMP_ID = '代码';
var $A_COMP_EXPIRED = '过期';
var $A_COMP_YES = '是';
var $A_COMP_NO = '否';
var $A_COMP_EDITING = '编辑';
var $A_COMP_ADDING = '新增';
var $A_COMP_ARCHIVED = '存档';
var $A_COMP_HITS = '点击';
var $A_COMP_SOURCE = '源文件';
var $A_COMP_SEL_ITEM = '选择条目来';
var $A_COMP_DATE = '日期';
var $A_COMP_AUTHOR = '作者';
var $A_COMP_ANOTHER_ADMIN = '正在被其他管理员编辑。';

//components/com_admin/admin.admin.html.php
var $A_COMP_ADMIN_TITLE = '控制面板';
var $A_COMP_ADMIN_INFO = '信息';
var $A_COMP_ADMIN_SYSTEM = '系统信息';

var $A_COMP_ADMIN_PHP_BUILT_ON = 'PHP系统环境：';
var $A_COMP_ADMIN_DB = '数据库版本：';
var $A_COMP_ADMIN_PHP_VERSION = 'PHP版本：';
var $A_COMP_ADMIN_SERVER = 'Web服务器：';
var $A_COMP_ADMIN_SERVER_TO_PHP = 'Web服务器和PHP的接口：';
var $A_COMP_ADMIN_AGENT = '客户端：';
var $A_COMP_ADMIN_SETTINGS = '相关的PHP设置：';
var $A_COMP_ADMIN_MODE = 'Safe Mode:';
var $A_COMP_ADMIN_BASEDIR = 'Open basedir:';
var $A_COMP_ADMIN_ERRORS = 'Display Errors:';
var $A_COMP_ADMIN_OPEN_TAGS = 'Short Open Tags:';
var $A_COMP_ADMIN_FILE_UPLOADS = 'File Uploads:';
var $A_COMP_ADMIN_QUOTES = 'Magic Quotes:';
var $A_COMP_ADMIN_REG_GLOBALS = 'Register Globals:';
var $A_COMP_ADMIN_OUTPUT_BUFF = 'Output Buffering:';
var $A_COMP_ADMIN_S_SAVE_PATH = 'Session save path:';
var $A_COMP_ADMIN_S_AUTO_START = 'Session auto start:';
var $A_COMP_ADMIN_XML = 'XML enabled:';
var $A_COMP_ADMIN_ZLIB = 'Zlib enabled:';
var $A_COMP_ADMIN_DISABLED = 'Disabled Functions:';
var $A_COMP_ADMIN_WYSIWYG = '可视化编辑器:';
var $A_COMP_ADMIN_CONF_FILE = 'Mambo配置文件：';
var $A_COMP_ADMIN_PHP_INFO2 = 'PHP信息';
var $A_COMP_ADMIN_PHP_INFO = 'PHP信息';
var $A_COMP_ADMIN_PERMISSIONS='目录权限';
var $A_COMP_ADMIN_DIR_PERM = '目录权限';
var $A_COMP_ADMIN_FOR_ALL = '为完全发挥Mambo的功能和特性，请将下列目录设为可写：';
var $A_COMP_ADMIN_CREDITS = '荣誉';
var $A_COMP_ADMIN_APP = '应用系统';
var $A_COMP_ADMIN_URL = '网址';
var $A_COMP_ADMIN_VERSION = '版本';
var $A_COMP_ADMIN_LICENSE = '许可';
var $A_COMP_ADMIN_CALENDAR = '日历';
var $A_COMP_ADMIN_PUB_DOMAIN = '公众域';
var $A_COMP_ADMIN_ICONS = '图标';
var $A_COMP_ADMIN_INDEX = '索引';
var $A_COMP_ADMIN_OPEN_NEW_WIN = '在新窗口打开';

//components/com_admin/admin.admin.php
var $A_COMP_ALERT_NO_LINK = '此条目没有关联的链接';

//components/com_banners/admin.banners.html.php
var $A_COMP_BANNERS_MANAGER = '横幅广告管理';
var $A_COMP_BANNERS_NAME = '横幅广告名称';
var $A_COMP_BANNERS_IMPRESS_MADE = '已浏览数';
var $A_COMP_BANNERS_IMPRESS_LEFT = '剩余浏览数';
var $A_COMP_BANNERS_CLICKS = '点击';
var $A_COMP_BANNERS_CLICKS2 = '点击%';
var $A_COMP_BANNERS_PUBLISHED = '发布';
var $A_COMP_BANNERS_LOCK = '取出';
var $A_COMP_BANNERS_PROVIDE = '请输入横幅广告名称。';
var $A_COMP_BANNERS_SELECT_IMAGE = '请选择图片。';
var $A_COMP_BANNERS_FILL_URL = '请输入横幅广告的网址。';
var $A_COMP_BANNERS_BANNER = '横幅广告';
var $A_COMP_BANNERS_CLIENT = '客户名称';
var $A_COMP_BANNERS_PURCHASED = '购买的浏览数：';
var $A_COMP_BANNERS_UNLIMITED = '无限制';
var $A_COMP_BANNERS_URL = '横幅广告网址：';
var $A_COMP_BANNERS_SHOW = '显示横幅广告：';
var $A_COMP_BANNERS_CLICK_URL = '目标网址：';
var $A_COMP_BANNERS_CUSTOM = '定制横幅广告代码：';
var $A_COMP_BANNERS_IMAGE = '横幅广告图片：';
var $A_COMP_BANNERS_CLIENT_MANAGER = '横幅广告客户管理';
var $A_COMP_BANNERS_NO_ACTIVE = '激活的横幅广告数';
var $A_COMP_BANNERS_FILL_CL_NAME = '请输入客户名称。';
var $A_COMP_BANNERS_FILL_CO_NAME = '请输入联系人。';
var $A_COMP_BANNERS_FILL_CO_EMAIL = '请输入Email。';
var $A_COMP_BANNERS_TITLE_CLIENT = '横幅广告客户';
var $A_COMP_BANNERS_CONTACT_NAME = '联系人';
var $A_COMP_BANNERS_CONTACT_EMAIL = 'Email';
var $A_COMP_BANNERS_EXTRA = '备注';

//components/com_banners/admin.banners.php
var $A_COMP_BANNERS_SELECT_CLIENT = '选择客户';
var $A_COMP_BANNERS_COMP = '组件';
var $A_COMP_BANNERS_EDITED = '正在被其他管理员编辑。';
var $A_COMP_BANNERS_DEL_CLIENT = '无法删除客户，因为还有正在运作的横幅广告';

//components/com_categories/admin.categories.html.php
var $A_COMP_CATEG_MANAGER = '分类管理';
var $A_COMP_CATEG_CATEGS = '分类';
var $A_COMP_CATEG_NAME = '分类名称';
var $A_COMP_CATEG_ID = '分类代码';
var $A_COMP_CATEG_MUST_NAME = '分类必须有名称';
var $A_COMP_CATEG_DETAILS = '分类明细';
var $A_COMP_CATEG_TITLE = '分类标题：';
var $A_COMP_CATEG_TABLE = '分类列表';
var $A_COMP_CATEG_BLOG = '分类Blog风格';
var $A_COMP_CATEG_BLOG_ARCHIVE = '存档分类Blog风格';
var $A_COMP_CATEG_MESSAGE = '分类';
var $A_COMP_CATEG_MESSAGE2 = '正在被其他管理员编辑。';
var $A_COMP_CATEG_MOVE = '移动分类';
var $A_COMP_CATEG_MOVE_TO_SECTION = '移动到单元';
var $A_COMP_CATEG_BEING_MOVED = '移动的分类';
var $A_COMP_CATEG_CONTENT = '移动的内容条目';
var $A_COMP_CATEG_MOVE_CATEG = '将移动所列的分类';
var $A_COMP_CATEG_ALL_ITEMS = '以及分类中的所有条目（也就是所列的）';
var $A_COMP_CATEG_TO_SECTION = '到指定的单元。';
var $A_COMP_CATEG_COPY = '复制分类';
var $A_COMP_CATEG_COPY_TO_SECTION = '复制到单元';
var $A_COMP_CATEG_BEING_COPIED = '复制的分类';
var $A_COMP_CATEG_ITEMS_COPIED = '复制的内容条目';
var $A_COMP_CATEG_COPY_CATEGS = '将复制所列的分类';

//components/com_categories/admin.categories.php
var $A_COMP_CATEG_DELETE = '选择要删除的分类';
var $A_COMP_CATEG_CATEG_S = '分类';
var $A_COMP_CATEG_CANNOT_REMOVE = '无法删除，因其有下属记录';
var $A_COMP_CATEG_SELECT = '选择分类来';
var $A_COMP_CATEG_ITEM_MOVE = '选择条目来移动';
var $A_COMP_CATEG_MOVED_TO = '分类移动到';
var $A_COMP_CATEG_COPY_OF = '复制';
var $A_COMP_CATEG_COPIED_TO = '分类复制到';
var $A_COMP_CATEG_SELECT_TYPE = '选择类型';

//components/com_categories/admin.checkin.php
var $A_COMP_CHECK_TITLE = '全部放回';
var $A_COMP_CHECK_DB_T = '数据库表格';
var $A_COMP_CHECK_NB_ITEMS = '条目数';
var $A_COMP_CHECK_IN = '放回';
var $A_COMP_CHECK_TABLE = '检查表格';
var $A_COMP_CHECK_DONE = '取出的条目已全部放回';

//components/com_categories/admin.config.html.php
var $A_COMP_CONF_GC = '全局配置';
var $A_COMP_CONF_IS = '为';
var $A_COMP_CONF_WRT = '可写';
var $A_COMP_CONF_UNWRT = '不可写';
//var $A_COMP_CONF_SITE_PAGE = 'site-page';
var $A_COMP_CONF_OFFLINE = '网站离线';
var $A_COMP_CONF_OFFMESSAGE = '离线消息';
var $A_COMP_CONF_ERR_MESSAGE = '系统错误消息';
var $A_COMP_CONF_SITE_NAME = '网站名称';
var $A_COMP_CONF_UN_LINKS = '显示未授权的链接';
var $A_COMP_CONF_USER_REG = '允许用户注册';
var $A_COMP_CONF_AC_ACT = '使用帐户激活';
var $A_COMP_CONF_REQ_EMAIL = '要求唯一的Email';
var $A_COMP_CONF_DEBUG = '调试网站';
var $A_COMP_CONF_EDITOR = '可视化编辑器';
var $A_COMP_CONF_LENGTH = '列表条目数';
//var $A_COMP_CONF_LOCAL_PG = 'Locale-page';
var $A_COMP_CONF_LOCALE = '本地';
var $A_COMP_CONF_LANG = '前台语言';
var $A_COMP_CONF_ALANG = '后台语言';
var $A_COMP_CONF_TIME_SET = '时差';
var $A_COMP_CONF_DATE = '当前日期/时间';
var $A_COMP_CONF_LOCAL = '国家代码';
//var $A_COMP_CONF_CONT_PAGE = 'content-page';
var $A_COMP_CONF_CONTROL = '* 下列参数控制内容的外观 *';
var $A_COMP_CONF_LINK_TITLES = '链接标题';
var $A_COMP_CONF_MORE_LINK = '更多链接';
var $A_COMP_CONF_RATE_VOTE = '条目评分/投票';
var $A_COMP_CONF_AUTHOR = '作者名称';
var $A_COMP_CONF_CREATED = '创建日期和时间';
var $A_COMP_CONF_MOD_DATE = '修改日期和时间';
var $A_COMP_CONF_HITS = '点击';
var $A_COMP_CONF_PDF = 'PDF图标';
var $A_COMP_CONF_OPT_MEDIA = '选项不可用，因为/media 目录不可写';
var $A_COMP_CONF_PRINT_ICON = '打印图标';
var $A_COMP_CONF_EMAIL_ICON = 'Email图标';
var $A_COMP_CONF_ICONS = '图标';
var $A_COMP_CONF_USE_OR_TEXT = '打印、生成PDF和发送Email 的图标或文本';
var $A_COMP_CONF_TBL_CONTENTS = '多页内容条目表格';
var $A_COMP_CONF_BACK_BUTTON = '返回按钮';
var $A_COMP_CONF_CONTENT_NAV = '内容条目导航';
var $A_COMP_CONF_HYPER = '使用超链接标题';
//var $A_COMP_CONF_DB_PAGE = 'db-page';
var $A_COMP_CONF_HOSTNAME = '主机名';
var $A_COMP_CONF_DB_USERNAME = '用户名';
var $A_COMP_CONF_DB_PW = '密码';
var $A_COMP_CONF_DB_NAME = '数据库';
var $A_COMP_CONF_DB_PREFIX = '数据表前缀';
var $A_COMP_CONF_NOT_CH = '！！ 不要改变！除非你已经手工设置了所有数据库表的前缀。 ！！';
//Svar $A_COMP_CONF_S_PAGE = 'server-page';
var $A_COMP_CONF_ABS_PATH = '绝对路径';
var $A_COMP_CONF_LIVE = '网站地址';
var $A_COMP_CONF_SECRET = '加密文本';
var $A_COMP_CONF_GZIP = '用 GZIP 压缩页面';
var $A_COMP_CONF_CP_BUFFER = '如果系统支持的话，压缩缓冲输出';
var $A_COMP_CONF_SESSION_TIME = 'session会话时间';
var $A_COMP_CONF_SEC = '秒';
var $A_COMP_CONF_AUTO_LOGOUT = '此时间内如果没有活动将自动退出登录';
var $A_COMP_CONF_ERR_REPORT = '错误报告';
var $A_COMP_CONF_META_PAGE = '元数据';
var $A_COMP_CONF_META_DESC = '全局的网站元描述';
var $A_COMP_CONF_META_KEY = '全局的网站元关键字';
var $A_COMP_CONF_META_TITLE = '显示标题的元标签';
var $A_COMP_CONF_META_ITEMS = '浏览内容条目时显示标题元标签';
var $A_COMP_CONF_META_AUTHOR = '显示作者的元标签';
//var $A_COMP_CONF_MAIL_PAGE = 'mail-page';
var $A_COMP_CONF_MAIL = '邮件发送';
var $A_COMP_CONF_MAIL_FROM = '发件人Email地址';
var $A_COMP_CONF_MAIL_FROM_NAME = '发件人姓名';
var $A_COMP_CONF_MAIL_SMTP_AUTH = 'SMTP认证';
var $A_COMP_CONF_MAIL_SMTP_USER = 'SMTP用户';
var $A_COMP_CONF_MAIL_SMTP_PASS = 'SMTP密码';
var $A_COMP_CONF_MAIL_SMTP_HOST = 'SMTP主机';
//var $A_COMP_CONF_CACHE_PAGE = 'cache-page';
var $A_COMP_CONF_CACHE = '使用缓存';
var $A_COMP_CONF_CACHE_FOLDER = '缓存目录';
var $A_COMP_CONF_CACHE_DIR = '当前缓存目录为';
var $A_COMP_CONF_CACHE_DIR_UNWRT = '缓存目录为不可写，在使用缓存功能之前请设置此目录为CHMOD755';
var $A_COMP_CONF_CACHE_TIME = '缓存时间';
//var $A_COMP_CONF_STATS_PAGE = 'stats-page';
var $A_COMP_CONF_STATS = '统计';
var $A_COMP_CONF_STATS_ENABLE = '允许/禁止收集网站统计信息';
var $A_COMP_CONF_STATS_LOG_HITS = '按日期分类记录内容点击';
var $A_COMP_CONF_STATS_WARN_DATA = '警告：大量数据将被收集';
var $A_COMP_CONF_STATS_LOG_SEARCH = '记录搜索文本';
//var $A_COMP_CONF_SEO_PAGE = 'seo-page';
var $A_COMP_CONF_SEO_LBL = '搜索引擎优化';
var $A_COMP_CONF_SEO = '搜索引擎优化';
var $A_COMP_CONF_SEO_SEFU = '搜索引擎友好链接';
var $A_COMP_CONF_SEO_APACHE = '只适用于Apache服务器! 激活前先把 htaccess.txt 改名为 .htaccess';
var $A_COMP_CONF_SEO_DYN = '动态页面标题';
var $A_COMP_CONF_SEO_DYN_TITLE = '动态更新页面标题，来更好表现当前的内容';
var $A_COMP_CONF_SERVER = '服务器';
var $A_COMP_CONF_METADATA = '元数据';
var $A_COMP_CONF_EMAIL = '邮件';
var $A_COMP_CONF_CACHE_TAB = '缓存';

//components/com_categories/admin.config.php
var $A_COMP_CONF_HIDE = '隐藏';
var $A_COMP_CONF_SHOW = '显示';
var $A_COMP_CONF_DEFAULT = '系统默认';
var $A_COMP_CONF_NONE = '无';
var $A_COMP_CONF_SIMPLE = '简单';
var $A_COMP_CONF_MAX = '最大';
var $A_COMP_CONF_MAIL_FC = 'PHP邮件功能';
var $A_COMP_CONF_SEND = 'Sendmail';
var $A_COMP_CONF_SMTP = 'SMTP服务器';
var $A_COMP_CONF_UPDATED = '配置已被更新！';
var $A_COMP_CONF_ERR_OCC = '发生错误！无法打开配置文件来写入！';

//components/com_categories/admin.contact.html.php
var $A_COMP_CONT_MANAGER = '联系人管理';
var $A_COMP_CONT_FILTER = '筛选';
var $A_COMP_CONT_YOUR_NAME = '必须输入名称。';
var $A_COMP_CONT_CATEG = '请选择分类。';
var $A_COMP_CONT_DETAILS = '联系人明细';
var $A_COMP_CONT_POSITION = '职位';
var $A_COMP_CONT_ADDRESS = '地址';
var $A_COMP_CONT_TOWN = '城市';
var $A_COMP_CONT_STATE = '省份';
var $A_COMP_CONT_COUNTRY = '国家';
var $A_COMP_CONT_POSTAL_CODE = '邮编';
var $A_COMP_CONT_TEL = '电话';
var $A_COMP_CONT_FAX = '传真';
var $A_COMP_CONT_INFO = '备注';
//var $A_COMP_CONT_PUBLISH = 'publish-page';
var $A_COMP_CONT_PUBLISHING = '发布';
var $A_COMP_CONT_SITE_DEFAULT = '网站默认';
//var $A_COMP_CONT_IMG_PAGE = 'images-page';
var $A_COMP_CONT_IMG_INFO = '图片';
var $A_COMP_CONT_PARAMS = '参数';
var $A_COMP_CONT_PARAMETERS = '参数';
var $A_COMP_CONT_PARAM_MESS = '* 下列参数控制联系人的明细显示 *';
var $A_COMP_CONT_PUB_TAB = '发布';
var $A_COMP_CONT_IMG_TAB = '图片';

//components/com_categories/admin.contact.php
var $A_COMP_CONT_SELECT_REC = '选择记录来';

//components/com_categories/admin.content.html.php
var $A_COMP_CONTENT_ALL_ITEMS = '所有内容条目';
var $A_COMP_CONTENT_START_ALWAYS = '开始：总是';
var $A_COMP_CONTENT_START = '开始';
var $A_COMP_CONTENT_FIN_NOEXP = '结束：没有过期';
var $A_COMP_CONTENT_FINISH = '结束';
var $A_COMP_CONTENT_PUBLISH_INFO = '发布';
var $A_COMP_CONTENT_TRASH = '请从列表中选择条目来放入回收站';
var $A_COMP_CONTENT_TRASH_MESS = '确认要把选中的条目放入回收站？ \n这并不彻底删除条目。';
var $A_COMP_CONTENT_ARCHIVE = '存档';
var $A_COMP_CONTENT_MANAGER = '管理';
var $A_COMP_CONTENT_ZERO = '确认重置点击数为0？\n任何未保存的更改将丢失。';
var $A_COMP_CONTENT_MUST_TITLE = '内容条目必须输入标题';
var $A_COMP_CONTENT_MUST_SECTION = '必须选择单元。';
var $A_COMP_CONTENT_MUST_CATEG = '必须选择分类。';
var $A_COMP_CONTENT_IN = '内容在';
var $A_COMP_CONTENT_TITLE_ALIAS = '标题别名';
var $A_COMP_CONTENT_ITEM_DETAILS = '条目明细';
var $A_COMP_CONTENT_INTRO = '摘要：(必填)';
var $A_COMP_CONTENT_MAIN = '正文：(可选)';
var $A_COMP_CONTENT_PUB_INFO = '发布';
var $A_COMP_CONTENT_FRONTPAGE = '显示在首页';
var $A_COMP_CONTENT_AUTHOR = '作者别名';
var $A_COMP_CONTENT_CREATOR = '更改创建者';
var $A_COMP_CONTENT_OVERRIDE = '更改创建时间';
var $A_COMP_CONTENT_START_PUB = '开始发布时间';
var $A_COMP_CONTENT_FINISH_PUB = '结束发布时间';
var $A_COMP_CONTENT_DRAFT_UNPUB = '未发布的草稿';
var $A_COMP_CONTENT_RESET_HIT = '重置点击数';
var $A_COMP_CONTENT_REVISED = '修改';
var $A_COMP_CONTENT_TIMES = '次数';
var $A_COMP_CONTENT_CREATED = '创建';
var $A_COMP_CONTENT_BY = '由';
var $A_COMP_CONTENT_NEW_DOC = '新文档';
var $A_COMP_CONTENT_LAST_MOD = '最新修改';
var $A_COMP_CONTENT_NOT_MOD = '未修改';
var $A_COMP_CONTENT_MOSIMAGE = 'Mambo图片控制';
var $A_COMP_CONTENT_SUB_FOLDER = '子目录';
var $A_COMP_CONTENT_GALLERY = '图库图片';
var $A_COMP_CONTENT_IMAGES = '内容图片';
var $A_COMP_CONTENT_UP = '向上';
var $A_COMP_CONTENT_DOWN = '向下';
var $A_COMP_CONTENT_REMOVE = '删除';
var $A_COMP_CONTENT_EDIT_IMAGE = '编辑选择的图片';
var $A_COMP_CONTENT_ALIGN = '对齐';
var $A_COMP_CONTENT_ALT = '替代文本';
var $A_COMP_CONTENT_BORDER = '边框';
var $A_COMP_CONTENT_APPLY = '应用';
var $A_COMP_CONTENT_PARAM = '参数控制';
var $A_COMP_CONTENT_PARAM_MESS = '* 下列参数只控制条目明细显示 *';
var $A_COMP_CONTENT_META_DATA = '元数据';
var $A_COMP_CONTENT_KEYWORDS = '关键字';
//var $A_COMP_CONTENT_LINK_PAGE = 'link-page';
var $A_COMP_CONTENT_LINK_CI = '这将在选择的菜单中创建一个 \'菜单项 - 内容条目\' 的链接';
var $A_COMP_CONTENT_LINK_NAME = '链接名称';
var $A_COMP_CONTENT_SOMETHING = '请选择';
var $A_COMP_CONTENT_MOVE_ITEMS = '移动条目';
var $A_COMP_CONTENT_MOVE_SECCAT = '移动到单元/分类';
var $A_COMP_CONTENT_ITEMS_MOVED = '移动的条目';
var $A_COMP_CONTENT_SECCAT = '请选择单元/分类';
var $A_COMP_CONTENT_COPY_ITEMS = '复制内容条目';
var $A_COMP_CONTENT_COPY_SECCAT = '复制到单元/分类';
var $A_COMP_CONTENT_ITEMS_COPIED = '复制的条目';
var $A_COMP_CONTENT_PUBLISHING = '发布';
var $A_COMP_CONTENT_IMAGES2 = '图片';
var $A_COMP_CONTENT_META_INFO = '元数据';
var $A_COMP_CONTENT_ADD_ETC = '加入单元/分类/标题';
var $A_COMP_CONTENT_LINK_TO_MENU = '链接到菜单';

//components/com_categories/admin.content.php
var $A_COMP_CONTENT_CACHE = '缓存已清空';
var $A_COMP_CONTENT_CANNOT = '不能编辑存档条目';
var $A_COMP_CONTENT_MODULE = '模块';
var $A_COMP_CONTENT_ANOTHER = '正在被其他管理员编辑。';
var $A_COMP_CONTENT_ARCHIVED = '条目成功存档';
var $A_COMP_CONTENT_PUBLISHED = '条目成功发布';
var $A_COMP_CONTENT_UNPUBLISHED = '条目成功取消发布';
var $A_COMP_CONTENT_SEL_TOG = '选择条目来打开';
var $A_COMP_CONTENT_SEL_DEL = '选择条目来删除';
var $A_COMP_CONTENT_SEL_MOVE = '选择条目来移动';
var $A_COMP_CONTENT_MOVED = '条目成功移动到单元';
var $A_COMP_CONTENT_ERR_OCCURRED = '发生错误';
var $A_COMP_CONTENT_COPIED = '条目成功复制到单元';
var $A_COMP_CONTENT_RESET_HIT_COUNT = '成功重置点击数';
var $A_COMP_CONTENT_IN_MENU = '(菜单项 - 静态内容) 链接';
var $A_COMP_CONTENT_SUCCESS = '成功创建';
var $A_COMP_CONTENT_SELECT_CAT = '选择分类';
var $A_COMP_CONTENT_SELECT_SEC = '选择单元';

//components/com_categories/toolbar.content.html.php
var $A_COMP_CONTENT_BAR_TRASH = '回收站';
var $A_COMP_CONTENT_BAR_MOVE = '移动';
var $A_COMP_CONTENT_BAR_COPY = '复制';
var $A_COMP_CONTENT_BAR_SAVE = '保存';

//components/com_categories/admin.frontpage.html.php
var $A_COMP_FRONT_PAGE_ITEMS = '首页条目';
var $A_COMP_FRONT_ORDER = '序号';

//components/com_categories/admin.frontpage.php
var $A_COMP_FRONT_COUNT_NUM = '参数 count 必须是数字';
var $A_COMP_FRONT_INTRO_NUM = '参数 intro 必须是数字';
var $A_COMP_FRONT_WELCOME = '欢迎光临';
var $A_COMP_FRONT_IDONOT = '没有内容';

//components/com_categories/admin.languages.html.php
var $A_COMP_LANG_INSTALL = '已安装语言';
var $A_COMP_LANG_LANG = '语言';
var $A_COMP_LANG_EMAIL = '作者 Email';
var $A_COMP_LANG_EDITOR = '语言编辑者';
var $A_COMP_LANG_FILE = '文件 language';

//components/com_categories/admin.languages.php
var $A_COMP_LANG_UPDATED = '配置成功更新！';
var $A_COMP_LANG_M_SURE = '错误！ 请确认 configuration.php 为可写。';
var $A_COMP_LANG_CANNOT = '不能删除正在使用的语言。';
var $A_COMP_LANG_FAILED_OPEN = '操作失败：无法打开';
var $A_COMP_LANG_FAILED_SPEC = '操作失败：没有指定的语言。';
var $A_COMP_LANG_FAILED_EMPTY = '操作失败：没有内容';
var $A_COMP_LANG_FAILED_UNWRT = '操作失败：文件不可写。';
var $A_COMP_LANG_FAILED_FILE = '操作失败：无法打开文件来写入。';

//components/com_categories/admin.mambots.html.php
var $A_COMP_MAMB_ADMIN = '管理';
var $A_COMP_MAMB_SITE = '网站';
var $A_COMP_MAMB_MANAGER = 'Mambot管理';
var $A_COMP_MAMB_NAME = 'Mambot名称';
var $A_COMP_MAMB_FILE = '文件';
var $A_COMP_MAMB_MUST_NAME = 'Mambot必须输入名称';
var $A_COMP_MAMB_MUST_FNAME = 'Mambot必须输入文件名称';
var $A_COMP_MAMB_DETAILS = 'Mambot明细';
var $A_COMP_MAMB_FOLDER = '目录';
var $A_COMP_MAMB_MFILE = 'Mambot文件';
var $A_COMP_MAMB_ORDER = 'Mambot排序';

//components/com_categories/admin.mambots.php
var $A_COMP_MAMB_EDIT = '正在被其他管理员编辑。';
var $A_COMP_MAMB_DEL = '选择mambot来删除';
var $A_COMP_MAMB_TO = '选择mambot';
var $A_COMP_MAMB_PUB = '发布';
var $A_COMP_MAMB_UNPUB = '取消发布';

//components/com_categories/admin.massmail.html.php
var $A_COMP_MASS_SUBJECT = '请输入主题';
var $A_COMP_MASS_SELECT_GROUP = '请选择群组';
var $A_COMP_MASS_MESSAGE = '请输入正文';
var $A_COMP_MASS_MAIL = '群发邮件';
var $A_COMP_MASS_GROUP = '群组';
var $A_COMP_MASS_CHILD = '发邮件给子群组';
var $A_COMP_MASS_SUB = '主题';
var $A_COMP_MASS_MESS = '正文';

//components/com_categories/admin.massmail.php
var $A_COMP_MASS_ALL = '- 所有用户群组 -';
var $A_COMP_MASS_FILL = '请正确填写表单';
var $A_COMP_MASS_SENT = '收件人E-mail';
var $A_COMP_MASS_USERS = '用户';

//components/com_media/admin.media.html.php
var $A_COMP_MEDIA_MG = '媒体管理';
var $A_COMP_MEDIA_DIR = '目录';
var $A_COMP_MEDIA_UP = '向上';
var $A_COMP_MEDIA_UPLOAD = '上传';
var $A_COMP_MEDIA_CODE = '代码';
var $A_COMP_MEDIA_CDIR = '创建目录';
var $A_COMP_MEDIA_PROBLEM = '配置问题';
var $A_COMP_MEDIA_EXIST = '不存在。';
var $A_COMP_MEDIA_DEL = '删除';
var $A_COMP_MEDIA_INSERT = '在此输入文本';
var $A_COMP_MEDIA_DEL_FILE = "删除文件 \"+file+\"?";
var $A_COMP_MEDIA_DEL_ALL = "有 \"+numFiles+\" 个文件/目录在 \"+folder+\"。请先删除 \"+folder+\"中的所有文件/目录  。";
var $A_COMP_MEDIA_DEL_FOLD = "删除目录 \"+folder+\"?";
var $A_COMP_MEDIA_NO_IMG = '没有图片。';

//components/com_media/admin.media.php
var $A_COMP_MEDIA_NO_HACK = '请不要修改';
var $A_COMP_MEDIA_DIR_SAFEMODE = '目录禁止创建，系统环境为SAFE MODE模式，会导致问题。';
var $A_COMP_MEDIA_ALPHA = '目录名称只能包含字母或数字，不能有空格';
var $A_COMP_MEDIA_FAILED = '上传失败。文件已经存在';
var $A_COMP_MEDIA_ONLY = '只有类型为 gif, png, jpg, bmp, pdf, swf, doc, xls 或者 ppt 的文件才能上传';
var $A_COMP_MEDIA_UP_FAILED = '上传失败';
var $A_COMP_MEDIA_UP_COMP = '上传完成';

//components/com_media/toolbar.media.html.php
var $A_COMP_MEDIA_CREATE = '创建';

//components/com_categories/admin.menumanager.html.php
var $A_COMP_MENU_NAME = '菜单名称';
var $A_COMP_MENU_TYPE = '菜单类型';
var $A_COMP_MENU_ID = '模块代码';
var $A_COMP_MENU_ASSIGN = '没有模块分配到菜单';
var $A_COMP_MENU_ENTER = '请输入菜单名称';
var $A_COMP_MENU_ENTER_TYPE = '请输入菜单类型';
var $A_COMP_MENU_DETAILS = '菜单明细';
var $A_COMP_MENU_MAINMENU = '主菜单模块，保存此菜单时，相同的名称将自动创建/更新。';
var $A_COMP_MENU_DEL = '删除菜单';
var $A_COMP_MENU_MODULE_DEL = '删除的菜单/模块';
var $A_COMP_MENU_ITEMS_DEL = '删除的菜单项';
var $A_COMP_MENU_WILL = '* 将';
var $A_COMP_MENU_WILL2 = '此菜单，<br />及其所有菜单项和关联的模块 *';
var $A_COMP_MENU_YOU_SURE = '确认删除此菜单？\n将删除菜单、菜单项和模块。';
var $A_COMP_MENU_NAME_MENU = '请输入复制菜单的名称';
var $A_COMP_MENU_COPY = '复制菜单';
var $A_COMP_MENU_NEW = '新菜单名称';
var $A_COMP_MENU_COPIED = '复制的菜单';
var $A_COMP_MENU_ITEMS_COPIED = '复制的菜单项';
var $A_COMP_MENU_MOD_MENU = '主菜单模块，保存此菜单时，相同的名称将自动创建/更改。';

//components/com_categories/admin.menumanager.php
var $A_COMP_MENU_CREATED = '新菜单创建了';
var $A_COMP_MENU_UPDATED = '菜单更新了';
var $A_COMP_MENU_DETECTED = '菜单删除了';
var $A_COMP_MENU_COPY_OF = '菜单的复制';
var $A_COMP_MENU_CONSIST = '创建了，包括';

//components/com_categories/toolbar.menumanager.html.php
var $A_COMP_MENU_BAR_DEL = '删除';

//components/com_categories/admin.messages.html.php
var $A_COMP_MESS_PRIVATE = '站内短信';
var $A_COMP_MESS_SEARCH = '搜索';
var $A_COMP_MESS_FROM = '发件人';
var $A_COMP_MESS_READ = '已读';
var $A_COMP_MESS_UNREAD = '未读';
var $A_COMP_MESS_CONF = '站内短信配置';
var $A_COMP_MESS_GENERAL = '基本';
var $A_COMP_MESS_SURE = '请确认';
var $A_COMP_MESS_INBOX = '锁定收件箱';
var $A_COMP_MESS_MAILME = '有新短信发邮件通知我';
var $A_COMP_MESS_VIEW = '查阅短信';
var $A_COMP_MESS_POSTED = '已发短信';
var $A_COMP_MESS_PROVIDE_SUB = '请输入主题';
var $A_COMP_MESS_PROVIDE_MESS = '请输入正文';
var $A_COMP_MESS_PROVIDE_REC = '请选择收件人';
var $A_COMP_MESS_NEW = '新短信';
var $A_COMP_MESS_TO = '收件人';

//components/com_categories/admin.modules.html.php
var $A_COMP_MOD_MANAGER = '模块管理';
var $A_COMP_MOD_NAME = '模块名称';
var $A_COMP_MOD_POSITION = '位置';
var $A_COMP_MOD_PAGES = '所在页面';
var $A_COMP_MOD_VARIES = '个别';
var $A_COMP_MOD_ALL = '全部';
var $A_COMP_MOD_USER = '用户';
var $A_COMP_MOD_MUST_TITLE = '模块必须有标题';
var $A_COMP_MOD_MODULE = '模块';
var $A_COMP_MOD_DETAILS = '模块明细';
var $A_COMP_MOD_SHOW_TITLE = '显示标题';
var $A_COMP_MOD_ORDER = '模块排序';
var $A_COMP_MOD_CONTENT = '内容';
var $A_COMP_MOD_MOD_POSITION = '模块位置';
var $A_COMP_MOD_ITEM_LINK = '菜单项链接';
var $A_COMP_MOD_TAB_LBL = '版面';

//components/com_categories/admin.modules.php
var $A_COMP_MOD_MODULES = '模块';
var $A_COMP_MOD_CANNOT = '不能删除，只能卸载，因为是Mambo核心模块。';
var $A_COMP_MOD_SELECT_TO = '选择模块来';

//components/com_categories/admin.newsfeeds.html.php
var $A_COMP_FEED_TITLE = '新闻导入管理';
var $A_COMP_FEED_NEWS = '新闻导入';
var $A_COMP_FEED_ARTICLES = '文章';
var $A_COMP_FEED_CACHE = '缓存时间(秒)';
var $A_COMP_FEED_FILL_NAME = '请输入新闻导入名称。';
var $A_COMP_FEED_SEL_CATEG = '请选择分类。';
var $A_COMP_FEED_FILL_LINK = '请输入新闻导入链接。';
var $A_COMP_FEED_FILL_NB = '请输入文章显示数量。';
var $A_COMP_FEED_FILL_REFRESH = '请输入缓存更新时间。';
var $A_COMP_FEED_LINK = '链接';
var $A_COMP_FEED_NB_ARTICLE = '文章数';
var $A_COMP_FEED_IN_SEC = '缓存时间(秒)';

//components/com_categories/admin.poll.html.php
var $A_COMP_POLL_MANAGER = '在线调查管理';
var $A_COMP_POLL_TITLE = '在线调查标题';
var $A_COMP_POLL_OPTIONS = '选项';
var $A_COMP_POLL_MUST_TITLE = '在线调查必须有标题';
var $A_COMP_POLL_NON_ZERO = '投票必须有间隔时间';
var $A_COMP_POLL_POLL = '在线调查';
var $A_COMP_POLL_SHOW = '在菜单项显示';
var $A_COMP_POLL_LAG = '间隔时间';
var $A_COMP_POLL_BETWEEN = '(投票之间的时间间隔)';

//components/com_categories/admin.poll.php
var $A_COMP_POLL_THE = '在线调查';
var $A_COMP_POLL_BEING = '正在被其他管理员编辑。';

//components/com_categories/poll.class.php
var $A_COMP_POLL_TRY_AGAIN = '模块名称已存在，请重试。';

//components/com_categories/admin.sections.html.php
var $A_COMP_SECT_MANAGER = '单元管理';
var $A_COMP_SECT_NAME = '单元名称';
var $A_COMP_SECT_ID = '单元代码';
var $A_COMP_SECT_NB_CATEG = '分类';
var $A_COMP_SECT_NEW = '新单元';
var $A_COMP_SECT_SEL_MENU = '请选择菜单';
var $A_COMP_SECT_MUST_NAME = '单元必须有名称';
var $A_COMP_SECT_MUST_TITLE = '单元必须有标题';
var $A_COMP_SECT_DETAILS = '单元明细';
var $A_COMP_SECT_SCOPE = '范围';
var $A_COMP_SECT_SHORT_NAME = '在菜单显示的简称';
var $A_COMP_SECT_LONG_NAME = '在标题显示的全称';
var $A_COMP_SECT_COPY = '复制单元';
var $A_COMP_SECT_COPY_TO = '复制到单元';
var $A_COMP_SECT_NEW_NAME = '新单元名称';
var $A_COMP_SECT_WILL_COPY = '将复制所列分类<br />以及分类中的所有条目（也就是所列的）<br />到新单元。';

//components/com_categories/admin.sections.php
var $A_COMP_SECT_THE = '单元';
var $A_COMP_SECT_LIST = '单元列表';
var $A_COMP_SECT_BLOG = '单元Blog风格';
var $A_COMP_SECT_ARCHIVE_BLOG = '存档单元Blog风格';
var $A_COMP_SECT_DELETE = '选择单元来删除';
var $A_COMP_SECT_SEC = '单元';
var $A_COMP_SECT_CANNOT = '不能删除，因其中还有分类';
var $A_COMP_SECT_SUCCESS_DEL = '成功删除';
var $A_COMP_SECT_TO = '选择单元来';
var $A_COMP_SECT_CANNOT_PUB = '不能发布空单元';
var $A_COMP_SECT_AND_ALL = '及其所有分类和条目已复制';
var $A_COMP_SECT_IN_MENU = '在菜单';

//components/com_categories/admin.statistics.html.php
var $A_COMP_STAT_OS = '浏览器、操作系统、域统计';
var $A_COMP_STAT_BR_PAGE = '浏览器统计';
var $A_COMP_STAT_BROWSER = '浏览器';
var $A_COMP_STAT_OS_PAGE = '操作系统统计';
var $A_COMP_STAT_OP_SYST = '操作系统';
var $A_COMP_STAT_URL_PAGE = '域统计';
var $A_COMP_STAT_URL = '域';
var $A_COMP_STAT_IMPR = '页面浏览统计';
var $A_COMP_STAT_PG_IMPR = '页面浏览';
var $A_COMP_STAT_SCH_ENG = '搜索文本统计';
var $A_COMP_STAT_LOG_IS = '记录';
var $A_COMP_STAT_ENABLED = '启用';
var $A_COMP_STAT_DISABLED = '禁用';
var $A_COMP_STAT_SCH_TEXT = '搜索文本';
var $A_COMP_STAT_T_REQ = '搜索次数';
var $A_COMP_STAT_R_RETURN = '返回结果';

//components/com_categories/admin.syndicate.html.php
var $A_COMP_SYND_SET = '新闻联合设置';

//components/com_categories/admin.syndicate.php
var $A_COMP_SYND_SAVED = '设置成功保存';

//components/com_categories/admin.templates.html.php
var $A_COMP_TEMP_NO_PREVIEW = '没有可用的预览';
var $A_COMP_TEMP_INSTALL = '安装';
var $A_COMP_TEMP_TP = '模版';
var $A_COMP_TEMP_PREVIEW = '预览模版';
var $A_COMP_TEMP_ASSIGN = '分配';
var $A_COMP_TEMP_AUTHOR_URL = '作者网址';
var $A_COMP_TEMP_EDITOR = '模版编辑者';
var $A_COMP_TEMP_PATH = '路径：templates';
var $A_COMP_TEMP_WRT = ' - 可写';
var $A_COMP_TEMP_UNWRT = ' - 不可写';
var $A_COMP_TEMP_ST_EDITOR = '模版 CSS 编辑器';
var $A_COMP_TEMP_NAME = '路径';
var $A_COMP_TEMP_ASSIGN_TP = '分配模版';
var $A_COMP_TEMP_TO_MENU = '到菜单项';
var $A_COMP_TEMP_PAGES = '页面';
var $A_COMP_TEMP_ = '位置';

//components/com_categories/admin.templates.php
var $A_COMP_TEMP_CANNOT = '无法删除正在使用的模版。';
var $A_COMP_TEMP_NOT_OPEN = '操作失败：无法打开';
var $A_COMP_TEMP_FLD_SPEC = '操作失败：没有指定的模版。';
var $A_COMP_TEMP_FLD_EMPTY = '操作失败：空内容';
var $A_COMP_TEMP_FLD_WRT = '操作失败：无法打开文件来写入。';
var $A_COMP_TEMP_FLD_NOT = '操作失败：文件不可写。';
var $A_COMP_TEMP_SAVED = '位置保存了';

//components/com_trash/admin.trash.html.php
var $A_COMP_TRASH_MANAGER = '回收站管理';
var $A_COMP_TRASH_ITEMS = '内容条目';
var $A_COMP_TRASH_MENU_ITEMS = '菜单项';
var $A_COMP_TRASH_DEL_ITEMS = '删除条目';
var $A_COMP_TRASH_NB_ITEMS = '条目数';
var $A_COMP_TRASH_ITEM_DEL = '删除的条目';
var $A_COMP_TRASH_PERM_DEL = '从数据库中彻底删除';
var $A_COMP_TRASH_THESE = '这些条目 *';
var $A_COMP_TRASH_YOU_SURE = '确认删除下列条目？ \n将彻底从数据库中删除。';
var $A_COMP_TRASH_RESTORE = '恢复条目';
var $A_COMP_TRASH_NUMBER = '条目数';
var $A_COMP_TRASH_ITEM_REST = '恢复的条目';
var $A_COMP_TRASH_REST = '恢复';
var $A_COMP_TRASH_RETURN = '这些条目，<br />它们将作为未发布的条目，恢复到原来位置 *';
var $A_COMP_TRASH_ARE_YOU = '确认恢复下列条目？';

//components/com_trash/admin.trash.php
var $A_COMP_TRASH_SUCCESS_DEL = '条目成功删除';
var $A_COMP_TRASH_SUCCESS_REST = '条目成功恢复';

//components/com_trash/toolbar.trash.html.php
var $A_COMP_TRASH_DEL = '删除';

//components/com_categories/admin.typedcontent.html.php
var $A_COMP_TYPED_STATIC = '静态内容管理';
var $A_COMP_TYPED_LINKS = '链接';
var $A_COMP_TYPED_ARE_YOU = '确认创建菜单链接到静态内容条目？ \n任何未保存的更改将丢失。';
var $A_COMP_TYPED_CONTENT = '静态内容';
var $A_COMP_TYPED_TEXT = '正文：(必填)';
var $A_COMP_TYPED_EXPIRES = '过期';
var $A_COMP_TYPED_WILL = '将在选中的菜单创建 \'菜单项 - 静态内容\' 的链接';

//components/com_categories/admin.typedcontent.php
var $A_COMP_TYPED_SAVED = '静态内容条目保存了';
var $A_COMP_TYPED_TRASHED = '条目放入回收站';

//components/com_categories/admin.users.html.php
var $A_COMP_USERS_ID = '用户代码';
var $A_COMP_USERS_LOG_IN = '登录';
var $A_COMP_USERS_LAST = '最近访问';
var $A_COMP_USERS_BLOCKED = '封锁';
var $A_COMP_USERS_YOU_MUST = '必须输入用户名。';
var $A_COMP_USERS_YOU_LOGIN = '用户名包含无效字符，或长度不够。';
var $A_COMP_USERS_MUST_EMAIL = '必须输入Email地址。';
var $A_COMP_USERS_ASSIGN = '必须分配用户到一个群组。';
var $A_COMP_USERS_NO_MATCH = '密码不匹配';
var $A_COMP_USERS_DETAILS = '用户明细';
var $A_COMP_USERS_EMAIL = 'Email';
var $A_COMP_USERS_PASS = '密码';
var $A_COMP_USERS_VERIFY = '密码确认';
var $A_COMP_USERS_BLOCK = '封锁用户';
var $A_COMP_USERS_SUBMI = '接收通知邮件';
var $A_COMP_USERS_REG_DATE = '注册日期';
var $A_COMP_USERS_VISIT_DATE = '最近访问日期';
var $A_COMP_USERS_CONTACT = '联系人信息';
var $A_COMP_USERS_NO_DETAIL = '没有此用户关联的联系人信息：<br />请到 \'组件 -> 联系人 -> 联系人管理\' 查阅详细信息。';
var $A_COMP_USERS_CHANGE_INFO = '要更改此信息：<br />请到 \'组件 -> 联系人 -> 联系人管理\'。';

//components/com_categories/admin.users.php
var $A_COMP_USERS_SUPER_ADMIN = 'Super Administrator';
var $A_COMP_USERS_CANNOT = '不能删除超级管理员';

//components/com_categories/toolbar.users.html.php
var $A_COMP_USERS_LOGOUT = '强制退出';

//components/com_categories/admin.weblinks.html.php
var $A_COMP_WEBL_MANAGER = '网站链接管理';
var $A_COMP_WEBL_APPROVED = '批准';
var $A_COMP_WEBL_MUST_TITLE = '网站链接条目必须输入标题';
var $A_COMP_WEBL_MUST_CATEG = '请选择分类.';
var $A_COMP_WEBL_MUST_URL = '必须输入网址';
var $A_COMP_WEBL_WL = '网站链接';

//components/com_installer/admin.installer.php
var $A_INSTALL_NOT_FOUND = "元件的安装文件未找到";
var $A_INSTALL_NOT_AVAIL = "元件的安装文件不可用";
var $A_INSTALL_ENABLE_MSG = "文件上传功能未启用，安装无法继续。请使用“从目录安装”的方法来安装。";
var $A_INSTALL_ERROR_MSG_TITLE = '安装 - 错误';
var $A_INSTALL_ZLIB_MSG = "zlib未安装，，安装无法继续。";
var $A_INSTALL_NOFILE_MSG = '尚未选择文件';
var $A_INSTALL_NEWMODULE_ERROR_MSG_TITLE = '上传新模块 - 错误';
var $A_INSTALL_UPLOAD_PRE = '上传 ';
var $A_INSTALL_UPLOAD_POST = ' - 上传失败';
var $A_INSTALL_UPLOAD_POST2 = ' -  上传错误';
var $A_INSTALL_SUCCESS = '成功';
var $A_INSTALL_ERROR = '错误';
var $A_INSTALL_FAILED = '失败';
var $A_INSTALL_SELECT_DIR = '请选择目录';
var $A_INSTALL_UPLOAD_NEW = '上传新';
var $A_INSTALL_FAIL_PERMISSION = '无法改变上传文件的权限。';
var $A_INSTALL_FAIL_MOVE = '无法移动上传文件到<code>/media</code>目录。';
var $A_INSTALL_FAIL_WRITE = '上传失败 - <code>/media</code> 目录不可写。';
var $A_INSTALL_FAIL_EXIST = '上传失败 - <code>/media</code> 目录不存在。';

//components/com_installer/admin.installer.html.php
var $A_INSTALL_WRITABLE = '可写';
var $A_INSTALL_UNWRITABLE = '不可写';
var $A_INSTALL_CONTINUE = '继续 ...';
var $A_INSTALL_UPLOAD_PACK_FILE = '上传安装包';
var $A_INSTALL_PACK_FILE = '安装包：';
var $A_INSTALL_UPL_INSTALL = "上传文件 &amp; 安装";
var $A_INSTALL_FROM_DIR = '从目录安装';
var $A_INSTALL_DIR = '安装目录：';
var $A_INSTALL_DO_INSTALL = '安装';

//components/com_installer/component/component.html.php
var $A_INSTALL_COMP_INSTALLED = '已安装组件';
var $A_INSTALL_COMP_CURRENT = '当前已安装';
var $A_INSTALL_COMP_MENU = '组件菜单链接';
var $A_INSTALL_COMP_AUTHOR = '作者';
var $A_INSTALL_COMP_VERSION = '版本';
var $A_INSTALL_COMP_DATE = '日期';
var $A_INSTALL_COMP_AUTH_MAIL = '作者Email';
var $A_INSTALL_COMP_AUTH_URL = '作者网址';
var $A_INSTALL_COMP_NONE = '尚未安装第三方组件';

//components/com_installer/component/component.php
var $A_INSTALL_COMP_UPL_NEW = '上传新组件';

//components/com_installer/language/language.php
var $A_INSTALL_LANG = '上传新语言';
var $A_INSTALL_BACK_LANG_MGR = '返回语言管理';

//components/com_installer/language/language.class.php
var $A_INSTALL_LANG_NOREMOVE = '语言代码为空，无法删除文件。';
var $A_INSTALL_LANG_UN_ERR = '卸载 - 错误';
var $A_INSTALL_LANG_DELETING = '删除';

//components/com_installer/mambot/mambot.html.php
var $A_INSTALL_MAMB_MAMBOTS = 'Mambots';
var $A_INSTALL_MAMB_CORE = '只显示那些可以卸载的Mambots - 一些核心Mambots不能删除。';
var $A_INSTALL_MAMB_MAMBOT = 'Mambot';
var $A_INSTALL_MAMB_TYPE = '类型';
var $A_INSTALL_MAMB_AUTHOR = '作者';
var $A_INSTALL_MAMB_VERSION = '版本';
var $A_INSTALL_MAMB_DATE = '日期';
var $A_INSTALL_MAMB_AUTH_MAIL = '作者Email';
var $A_INSTALL_MAMB_AUTH_URL = '作者网址';
var $A_INSTALL_MOD_NO_MAMBOTS = '尚未有非核心、第三方mambots安装。';

//components/com_installer/mambot/mambot.php
var $A_INSTALL_MAMB_INSTALL_MAMBOT = '安装Mambot';

//components/com_installer/module/module.html.php
var $A_INSTALL_MOD_MODS = '模块';
var $A_INSTALL_MOD_FILTER = '筛选：';
var $A_INSTALL_MOD_CORE = '只显示那些可以卸载的模块 - 一些核心模块不能删除。';
var $A_INSTALL_MOD_MOD = '模块文件';
var $A_INSTALL_MOD_CLIENT = '客户';
var $A_INSTALL_MOD_AUTHOR = '作者';
var $A_INSTALL_MOD_VERSION = '版本';
var $A_INSTALL_MOD_DATE = '日期';
var $A_INSTALL_MOD_AUTH_MAIL = '作者Email';
var $A_INSTALL_MOD_AUTH_URL = '作者网址';
var $A_INSTALL_MOD_NO_CUSTOM = '尚未有第三方模块安装。';

//components/com_installer/module/module.php
var $A_INSTALL_MOD_INSTALL_MOD = '安装模块';
var $A_INSTALL_MOD_ADMIN_MOD = '管理模块';

//components/com_install/template/template.php
var $A_INSTALL_TEMPL_INSTALL = '安装 ';
var $A_INSTALL_TEMPL_SITE_TEMPL = '网站模版';
var $A_INSTALL_TEMPL_ADMIN_TEMPL = '后台模版';
var $A_INSTALL_TEMPL_BACKTTO_TEMPL = '返回模版';
//components/com_menus/admin.menus.html.php
var $A_COMP_MENUS_MAX_LVLS = '最大级数';
var $A_COMP_MENUS_MENU_ITEM = '菜单项';
var $A_COMP_MENUS_ADD_ITEM = '新增菜单项';
var $A_COMP_MENUS_SELECT_ADD = '选择组件来新增';
var $A_COMP_MENUS_MOVE_ITEMS = '移动菜单项';
var $A_COMP_MENUS_MOVE_MENU = '移动到菜单';
var $A_COMP_MENUS_BEING_MOVED = '移动的菜单项';
var $A_COMP_MENUS_NEXT = '下一步';
var $A_COMP_MENUS_COPY_MENU = '复制到菜单';
var $A_COMP_MENUS_BEING_COPIED = '复制的菜单项';

//components/com_menus/admin.menus.php
var $A_COMP_MENUS_MOVED_TO = ' 菜单项移动到';
var $A_COMP_MENUS_COPIED_TO = ' 菜单项复制到';
var $A_COMP_MENUS_WRAPPER = '嵌入页面';
var $A_COMP_MENUS_SEPERATOR = '分隔符/占位符';
var $A_COMP_MENUS_LINK = '链接 - ';
var $A_COMP_MENUS_STATIC = '静态内容';
var $A_COMP_MENUS_URL = '网址';
var $A_COMP_MENUS_CONTENT_ITEM = '内容条目';
var $A_COMP_MENUS_COMP_ITEM = '组件条目';
var $A_COMP_MENUS_CONT_ITEM = '联系人条目';
var $A_COMP_MENUS_NEWSFEED = '新闻导入';
var $A_COMP_MENUS_COMP = '组件';
var $A_COMP_MENUS_LIST = '列表';
var $A_COMP_MENUS_TABLE = '表格';
var $A_COMP_MENUS_BLOG = 'Blog风格';
var $A_COMP_MENUS_CONT_SEC = '内容单元';
var $A_COMP_MENUS_CONT_CAT = '内容分类';
var $A_COMP_MENUS_CONT_SEC_MULTI = '内容单元并联';
var $A_COMP_MENUS_CONT_CAT_MULTI = '内容分类并联';
var $A_COMP_MENUS_CONT_SEC_ARCH = '存档内容单元';
var $A_COMP_MENUS_CONT_CAT_ARCH = '存档内容分类';
var $A_COMP_MENUS_CONTACT_CAT = '联系人分类';
var $A_COMP_MENUS_WEBLINK_CAT = '网站链接分类';
var $A_COMP_MENUS_NEWS_CAT = '新闻导入分类';

//components/com_menus/component_item_link/component_item_link.menu.html.php
var $A_COMP_MENUS_CIL_LINK_NAME = '链接必须输入名称';
var $A_COMP_MENUS_CIL_SELECT_COMP = '必须选择组件来链接';
var $A_COMP_MENUS_CIL_LINK_COMP = '组件';
var $A_COMP_MENUS_CIL_ON_CLICK = '点击打开方式';
var $A_COMP_MENUS_CIL_PARENT = '父菜单项';
var $A_DETAILS = '明细';

//components/com_menus/components/components.menu.html.php
var $A_COMP_MENUS_CMP_ITEM_NAME = '必须输入名称';
var $A_COMP_MENUS_CMP_SELECT_CMP = '请选择组件';
var $A_COMP_MENUS_PARAMETERS_AVAILABLE = '一旦保存此新的菜单项，下列参数就可用了';
var $A_COMP_MENUS_CMP_ITEM_COMP = '菜单项 :: 组件';

//components/com_menus/contact_category_table/contact_category_table.menu.html.php
var $A_COMP_MENUS_CMP_CCT_CATEG = '必须选择分类';
var $A_COMP_MENUS_CMP_CCT_TITLE = '菜单项必须有标题';
var $A_COMP_MENUS_CMP_CCT_BLANK = '如果留空，将自动使用分类名称。';
var $A_COMP_MENUS_CMP_CCT_THETITLE = '标题：';
var $A_COMP_MENUS_CMP_CCT_THECAT = '分类：';

//components/com_menus/contact_item_link/contact_item_link.menu.html.php
var $A_COMP_MENUS_CMP_CIL_LINK_NAME = '链接必须有名称';
var $A_COMP_MENUS_CMP_CIL_SEL_CONT = '必须选择一个联系人来链接。';
var $A_COMP_MENUS_CMP_CIL_CONTACT = '链接联系人';
var $A_COMP_MENUS_CMP_CIL_ONCLICK = '点击打开方式';
var $A_COMP_MENUS_CMP_CIL_HDR = '菜单项 :: 链接 - 联系人';

//components/com_menus/wrapper/wrapper.menu.html.php
var $A_COMP_MENUS_WRAPPER_LINK = '嵌入页面链接';

//components/com_menus/separator/separator.menu.html.php
var $A_COMP_MENUS_SEPARATOR_PATTERN = '模式';

//components/com_menus/content_typed/content_typed.menu.html.php
var $A_COMP_MENUS_TYPED_CONTENT_TO_LINK = '链接静态内容';

//components/com_menus/content_item_link/content_item_link.menu.html.php
var $A_COMP_MENUS_CONTENT_TO_LINK = '链接内容';

//components/com_menus/newsfeed_link/newsfeed_link.menu.html.php
var $A_COMP_MENUS_NEWSFEED_TO_LINK = '链接新闻导入';

}

?>
